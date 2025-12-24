<?php

namespace Database\Seeders;

use App\Models\Mensaje;
use App\Models\MensajeAdjunto;
use App\Models\MensajeDestinatario;
use App\Models\Notificacion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ComunicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = User::all();

        if ($usuarios->isEmpty()) {
            $this->command->warn('No hay usuarios en la base de datos.');
            return;
        }

        $mensajesCreados = 0;
        $adjuntosCreados = 0;
        $destinatariosCreados = 0;
        $notificacionesCreadas = 0;

        // Crear mensajes individuales
        foreach ($usuarios->random(min(10, $usuarios->count())) as $remitente) {
            $numMensajes = rand(2, 5);

            for ($i = 0; $i < $numMensajes; $i++) {
                $destinatario = $usuarios->where('id', '!=', $remitente->id)->random();
                $fechaEnvio = Carbon::now()->subDays(rand(1, 30));
                $esLeido = rand(1, 100) <= 70; // 70% leídos

                $mensaje = Mensaje::create([
                    'remitente_id' => $remitente->id,
                    'destinatario_id' => $destinatario->id,
                    'tipo' => 'individual',
                    'asunto' => $this->getAsuntoAleatorio(),
                    'cuerpo' => $this->getCuerpoAleatorio(),
                    'es_leido' => $esLeido,
                    'fecha_lectura' => $esLeido ? $fechaEnvio->copy()->addHours(rand(1, 48)) : null,
                    'fecha_envio' => $fechaEnvio,
                ]);

                $mensajesCreados++;

                // 30% tienen adjuntos
                if (rand(1, 100) <= 30) {
                    MensajeAdjunto::create([
                        'mensaje_id' => $mensaje->id,
                        'nombre_archivo' => 'documento_' . $mensaje->id . '.pdf',
                        'ruta_archivo' => 'mensajes/adjuntos/' . $mensaje->id . '/documento.pdf',
                        'tipo_mime' => 'application/pdf',
                        'tamanio' => rand(100000, 2000000),
                    ]);

                    $adjuntosCreados++;
                }
            }
        }

        // Crear algunos mensajes masivos/anuncios
        $docentesAdmin = $usuarios->filter(function($user) {
            return $user->hasRole(['administrador', 'profesor']);
        });

        if ($docentesAdmin->isNotEmpty()) {
            for ($i = 0; $i < 3; $i++) {
                $remitente = $docentesAdmin->random();
                $fechaEnvio = Carbon::now()->subDays(rand(1, 15));

                $mensaje = Mensaje::create([
                    'remitente_id' => $remitente->id,
                    'destinatario_id' => null,
                    'tipo' => rand(1, 100) <= 50 ? 'masivo' : 'anuncio',
                    'asunto' => $this->getAsuntoAnuncio(),
                    'cuerpo' => $this->getCuerpoAnuncio(),
                    'es_leido' => false,
                    'fecha_envio' => $fechaEnvio,
                ]);

                $mensajesCreados++;

                // Agregar destinatarios para mensajes masivos
                $destinatarios = $usuarios->where('id', '!=', $remitente->id)->random(min(10, $usuarios->count() - 1));

                foreach ($destinatarios as $dest) {
                    $esLeido = rand(1, 100) <= 60;

                    MensajeDestinatario::create([
                        'mensaje_id' => $mensaje->id,
                        'destinatario_id' => $dest->id,
                        'es_leido' => $esLeido,
                        'fecha_lectura' => $esLeido ? $fechaEnvio->copy()->addHours(rand(1, 72)) : null,
                    ]);

                    $destinatariosCreados++;
                }
            }
        }

        // Crear notificaciones para usuarios
        foreach ($usuarios->random(min(15, $usuarios->count())) as $usuario) {
            $numNotificaciones = rand(3, 8);

            for ($i = 0; $i < $numNotificaciones; $i++) {
                $tipo = $this->getTipoNotificacion();
                $esLeida = rand(1, 100) <= 65; // 65% leídas
                $enviarEmail = rand(1, 100) <= 40; // 40% se envían por email

                Notificacion::create([
                    'user_id' => $usuario->id,
                    'tipo' => $tipo,
                    'titulo' => $this->getTituloNotificacion($tipo),
                    'mensaje' => $this->getMensajeNotificacion($tipo),
                    'url' => $this->getUrlNotificacion($tipo),
                    'es_leida' => $esLeida,
                    'enviar_email' => $enviarEmail,
                    'email_enviado' => $enviarEmail ? (rand(1, 100) <= 90) : false,
                    'fecha_envio' => $enviarEmail ? Carbon::now()->subDays(rand(1, 20)) : null,
                ]);

                $notificacionesCreadas++;
            }
        }

        $this->command->info("✅ Se crearon $mensajesCreados mensajes");
        $this->command->info("✅ Se crearon $adjuntosCreados archivos adjuntos");
        $this->command->info("✅ Se crearon $destinatariosCreados registros de destinatarios");
        $this->command->info("✅ Se crearon $notificacionesCreadas notificaciones");
    }

    private function getAsuntoAleatorio(): string
    {
        $asuntos = [
            'Consulta sobre calificaciones',
            'Solicitud de reunión',
            'Información importante',
            'Confirmación de asistencia',
            'Consulta académica',
            'Actualización de datos',
            'Recordatorio de evento',
        ];

        return $asuntos[array_rand($asuntos)];
    }

    private function getCuerpoAleatorio(): string
    {
        $cuerpos = [
            'Estimado/a, le escribo para consultar sobre un tema académico importante. Espero su pronta respuesta.',
            'Buenos días, necesito información adicional sobre el proceso académico. Agradeceré su ayuda.',
            'Por favor, confirme la recepción de este mensaje a la brevedad posible.',
            'Le informo que he revisado la documentación y tengo algunas preguntas al respecto.',
            'Quisiera coordinar una reunión para tratar temas relacionados con el rendimiento académico.',
        ];

        return $cuerpos[array_rand($cuerpos)];
    }

    private function getAsuntoAnuncio(): string
    {
        $asuntos = [
            'Importante: Cambio de horario',
            'Recordatorio: Reunión de padres de familia',
            'Anuncio: Actividades extracurriculares',
            'Comunicado: Fechas de evaluaciones',
            'Aviso: Feriado próximo',
        ];

        return $asuntos[array_rand($asuntos)];
    }

    private function getCuerpoAnuncio(): string
    {
        $cuerpos = [
            'Estimados miembros de la comunidad educativa, les informamos sobre cambios importantes en el calendario académico.',
            'Se comunica a todos los interesados sobre las actividades programadas para las próximas semanas.',
            'Por este medio se notifica sobre actualizaciones en el cronograma institucional.',
            'Mediante el presente, hacemos de su conocimiento información relevante para la comunidad.',
        ];

        return $cuerpos[array_rand($cuerpos)];
    }

    private function getTipoNotificacion(): string
    {
        $tipos = ['calificacion', 'asistencia', 'tarea', 'mensaje', 'evento', 'general'];
        return $tipos[array_rand($tipos)];
    }

    private function getTituloNotificacion(string $tipo): string
    {
        $titulos = [
            'calificacion' => ['Nueva calificación registrada', 'Actualización de notas', 'Calificación publicada'],
            'asistencia' => ['Registro de asistencia', 'Inasistencia registrada', 'Justificación revisada'],
            'tarea' => ['Nueva tarea asignada', 'Fecha límite próxima', 'Tarea calificada'],
            'mensaje' => ['Nuevo mensaje recibido', 'Respuesta a tu mensaje', 'Mensaje importante'],
            'evento' => ['Próximo evento', 'Recordatorio de actividad', 'Cambio en evento'],
            'general' => ['Notificación del sistema', 'Actualización importante', 'Aviso general'],
        ];

        $lista = $titulos[$tipo] ?? $titulos['general'];
        return $lista[array_rand($lista)];
    }

    private function getMensajeNotificacion(string $tipo): string
    {
        $mensajes = [
            'calificacion' => 'Se ha registrado una nueva calificación en tu historial académico.',
            'asistencia' => 'Tu asistencia ha sido registrada. Revisa los detalles en el sistema.',
            'tarea' => 'Tienes una nueva tarea asignada. Revisa los detalles y la fecha de entrega.',
            'mensaje' => 'Has recibido un nuevo mensaje. Revisa tu bandeja de entrada.',
            'evento' => 'Se ha programado un nuevo evento. Consulta los detalles en el calendario.',
            'general' => 'Tienes una nueva notificación del sistema educativo.',
        ];

        return $mensajes[$tipo] ?? $mensajes['general'];
    }

    private function getUrlNotificacion(string $tipo): ?string
    {
        $urls = [
            'calificacion' => '/calificaciones',
            'asistencia' => '/asistencias',
            'tarea' => '/tareas',
            'mensaje' => '/mensajes',
            'evento' => '/eventos',
            'general' => '/inicio',
        ];

        return $urls[$tipo] ?? null;
    }
}
