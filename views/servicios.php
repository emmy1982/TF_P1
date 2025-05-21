<?php
$servicioId = isset($_GET['id']) ? $_GET['id'] : null;

$servicios = [
    1 => [
        'nombre' => 'Endodoncia',
        'titulo' => 'Tratamiento especializado de conductos',
        'imagen' => './assets/img/card3.jpg',
        'descripcion' => 'Tratamiento de casos complejos, reendodoncias y microcirugías apicales con tecnología de vanguardia.',
        'detalle' => 'La endodoncia es el procedimiento que consiste en la extirpación de la pulpa dental y el posterior relleno y sellado de la cavidad pulpar con un material biocompatible. En Clínica BRILLADENT somos especialistas en este tratamiento y disponemos de todas las herramientas necesarias para garantizar un resultado óptimo.',
        'ventajas' => [
            'Mayor precisión gracias al uso de microscopio operatorio',
            'Tratamientos menos invasivos',
            'Máxima preservación de la estructura dental',
            'Menor tiempo de recuperación',
            'Mínimas molestias post-operatorias',
            'Mayor tasa de éxito a largo plazo'
        ],
        'procedimiento' => [
            'Diagnóstico completo con radiografías digitales y CBCT 3D',
            'Anestesia local para garantizar comodidad durante el procedimiento',
            'Aislamiento con dique de goma para mantener el campo operatorio libre de contaminación',
            'Acceso y limpieza del sistema de conductos',
            'Conformación y desinfección con sistemas de última generación',
            'Obturación tridimensional para un sellado hermético',
            'Control radiográfico final y seguimiento'
        ],
        'preguntas' => [
            'pregunta1' => '¿Es doloroso el tratamiento de endodoncia?',
            'respuesta1' => 'No, con las técnicas modernas y la anestesia adecuada, el tratamiento de endodoncia es indoloro. Después del procedimiento puede haber alguna molestia leve que se controla fácilmente con analgésicos convencionales.',
            'pregunta2' => '¿Cuánto tiempo dura un tratamiento de endodoncia?',
            'respuesta2' => 'Dependiendo de la complejidad del caso, puede realizarse en una o varias sesiones. Cada sesión suele durar entre 60 y 90 minutos.',
            'pregunta3' => '¿Qué debo esperar después del tratamiento?',
            'respuesta3' => 'Es normal sentir ligera sensibilidad durante unos días. Debe evitar masticar alimentos duros con el diente tratado hasta que se complete la restauración definitiva.'
        ]
    ],
    2 => [
        'nombre' => 'Traumatología Dental',
        'titulo' => 'Tratamiento especializado de traumatismos dentales',
        'imagen' => './assets/img/card4.jpg',
        'descripcion' => 'Máxima tecnología para obtener la excelencia en nuestros tratamientos de urgencias traumáticas.',
        'detalle' => 'La traumatología dental se centra en el diagnóstico, prevención y tratamiento de lesiones traumáticas en los dientes y tejidos de soporte. En BRILLADENT contamos con profesionales especializados en el manejo de emergencias dentales por traumatismo, ofreciendo soluciones inmediatas para preservar la estructura dental y minimizar secuelas.',
        'ventajas' => [
            'Atención inmediata en casos de urgencia',
            'Tecnología avanzada para diagnóstico preciso',
            'Protocolos específicos según tipo de traumatismo',
            'Tratamientos conservadores y mínimamente invasivos',
            'Seguimiento exhaustivo post-traumático',
            'Alta tasa de preservación dental'
        ],
        'procedimiento' => [
            'Evaluación inicial y clasificación del traumatismo',
            'Diagnóstico mediante radiografías digitales y CBCT 3D',
            'Estabilización de estructuras móviles o desplazadas',
            'Tratamiento específico según tipo de traumatismo (fracturas, luxaciones, avulsiones)',
            'Rehabilitación funcional y estética',
            'Controles periódicos para evaluar evolución'
        ],
        'preguntas' => [
            'pregunta1' => '¿Qué debo hacer si me rompo un diente?',
            'respuesta1' => 'Conserve el fragmento en leche o suero fisiológico y acuda inmediatamente a nuestra clínica. El tiempo es crucial para aumentar las posibilidades de éxito en la reconstrucción.',
            'pregunta2' => '¿Se puede reimplantar un diente completamente salido?',
            'respuesta2' => 'Sí, pero es fundamental actuar rápidamente. Recoja el diente por la corona (sin tocar la raíz), enjuáguelo brevemente sin frotar y manténgalo en leche o suero mientras acude urgentemente a la clínica.',
            'pregunta3' => '¿Qué secuelas pueden quedar después de un traumatismo dental?',
            'respuesta3' => 'Las posibles secuelas dependen del tipo y gravedad del traumatismo. Pueden incluir oscurecimiento dental, reabsorciones radiculares o necesidad de tratamiento endodóntico. Un manejo adecuado reduce significativamente estas complicaciones.'
        ]
    ],
    3 => [
        'nombre' => 'Formación para Profesionales',
        'titulo' => 'Programas de especialización en endodoncia',
        'imagen' => './assets/img/card5.jpg',
        'descripcion' => 'Ofrecemos estancias clínicas para profesionales que quieran mejorar sus conocimientos y técnicas en Endodoncia Microscópica y Traumatología Dental.',
        'detalle' => 'En Clínica BRILLADENT estamos comprometidos con la excelencia en la formación continuada. Nuestro programa de estancias clínicas está diseñado para odontólogos que deseen perfeccionar sus habilidades en endodoncia microscópica y manejo de traumatismos dentales bajo la tutela de reconocidos especialistas.',
        'ventajas' => [
            'Aprendizaje práctico con casos reales',
            'Grupos reducidos para atención personalizada',
            'Utilización de microscopio operatorio',
            'Manejo de tecnología de última generación',
            'Certificación avalada por nuestros especialistas',
            'Acceso a protocolos clínicos exclusivos'
        ],
        'procedimiento' => [
            'Formación teórica con los fundamentos científicos actualizados',
            'Prácticas en simuladores avanzados',
            'Observación de tratamientos reales',
            'Asistencia supervisada en casos clínicos',
            'Tratamientos realizados por el alumno bajo supervisión',
            'Evaluación continua y feedback personalizado'
        ],
        'preguntas' => [
            'pregunta1' => '¿Cuál es la duración de los programas de formación?',
            'respuesta1' => 'Ofrecemos programas modulares desde 2 días hasta cursos intensivos de 3 meses, adaptados a las necesidades y disponibilidad de cada profesional.',
            'pregunta2' => '¿Es necesario tener experiencia previa en endodoncia?',
            'respuesta2' => 'Disponemos de programas para diferentes niveles, desde odontólogos generales que quieren iniciarse en la endodoncia avanzada hasta endodoncistas que desean perfeccionar técnicas específicas.',
            'pregunta3' => '¿Se proporciona material para realizar los tratamientos?',
            'respuesta3' => 'Sí, todos los materiales, instrumentos y equipamiento necesarios están incluidos en el programa. El alumno solo necesita traer sus lupas personales si las utiliza habitualmente.'
        ]
    ]
];

if (!$servicioId || !isset($servicios[$servicioId])) {
    header('Location: index.php');
    exit;
}

// Obtener los datos del servicio seleccionado
$servicio = $servicios[$servicioId];
?>

<div class="main-content">
<div class="section hero-small servicio-hero page-transition">
    <div class="container">
        <h1 class="page-transition delay-1"><?php echo $servicio['nombre']; ?></h1>
        <h2 class="page-transition delay-2"><?php echo $servicio['titulo']; ?></h2>
    </div>
</div>

<div class="section">
    <div class="container-card">
        <div class="servicio-intro">
            <div class="servicio-imagen page-transition delay-1">
                <img src="<?php echo $servicio['imagen']; ?>" alt="<?php echo $servicio['nombre']; ?>">
                <div class="img-overlay"></div>
            </div>
            <div class="servicio-descripcion page-transition delay-2">
                <h3><?php echo $servicio['nombre']; ?></h3>
                <p class="servicio-intro-texto"><?php echo $servicio['descripcion']; ?></p>
                <p class="servicio-detalle"><?php echo $servicio['detalle']; ?></p>
            </div>
        </div>
        
        <div class="servicio-content">
            <div class="servicio-ventajas page-transition delay-3">
                <h4>Ventajas de nuestro servicio</h4>
                <ul>
                    <?php foreach ($servicio['ventajas'] as $ventaja): ?>
                        <li><?php echo $ventaja; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="servicio-procedimiento">
                <h4>Procedimiento</h4>
                <ol>
                    <?php foreach ($servicio['procedimiento'] as $paso): ?>
                        <li><?php echo $paso; ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
            
            <div class="servicio-faqs">
                <h4>Preguntas frecuentes</h4>
                <div class="faq-item">
                    <h5><?php echo $servicio['preguntas']['pregunta1']; ?></h5>
                    <p><?php echo $servicio['preguntas']['respuesta1']; ?></p>
                </div>
                <div class="faq-item">
                    <h5><?php echo $servicio['preguntas']['pregunta2']; ?></h5>
                    <p><?php echo $servicio['preguntas']['respuesta2']; ?></p>
                </div>
                <div class="faq-item">
                    <h5><?php echo $servicio['preguntas']['pregunta3']; ?></h5>
                    <p><?php echo $servicio['preguntas']['respuesta3']; ?></p>
                </div>
            </div>
        </div>
        
        <div class="servicio-cta">
            <p>¿Necesita más información sobre nuestro servicio de <?php echo $servicio['nombre']; ?>?</p>
            <a href="index.php?page=citaciones" class="btn btn-outline btn-lg">SOLICITAR CITA</a>
        </div>
        
        <div class="otros-servicios">
            <h3>Otros servicios</h3>
            <div class="servicios-links">
                <?php foreach ($servicios as $id => $serv): ?>
                    <?php if ($id != $servicioId): ?>
                        <a href="index.php?page=servicios&id=<?php echo $id; ?>" class="btn btn-light">
                            <?php echo $serv['nombre']; ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</div> 