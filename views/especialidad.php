<?php
$doctorId = isset($_GET['doctor']) ? $_GET['doctor'] : null;

$doctores = [
    1 => [
        'nombre' => 'Dr. Sebastian Carranza',
        'titulo' => 'Especialista en Endodoncia Microscópica',
        'imagen' => './assets/img/doctores(1).png',
        'descripcion' => 'Pionero en técnicas avanzadas de microcirugía apical y tratamiento de casos complejos de endodoncia.',
        'especialidad' => 'La Endodoncia Microscópica permite abordar casos extremadamente complejos con una precisión incomparable. El uso del microscopio operatorio ZEISS Extaro 300 con aumentos de hasta 25x posibilita visualizar detalles imposibles de detectar a simple vista, incrementando significativamente la tasa de éxito en tratamientos como:',
        'tratamientos' => [
            'Retratamientos de conductos fracasados',
            'Localización de conductos calcificados',
            'Retirada de instrumentos fracturados',
            'Reparación de perforaciones',
            'Tratamiento de conductos con anatomía compleja',
            'Microcirugía apical mínimamente invasiva'
        ],
        'formacion' => [
            'Presidente electo de la Sociedad Española de Endodoncia',
            'Director del Máster de Endodoncia microscópica y cirugía apical de la Universidad Rey Juan Carlos',
            'Profesor del International Dental Institute (Palm Beach, Florida, EEUU)',
            'Máster de Endodoncia, Southern Mississippi University (USM)',
            'Autor de múltiples publicaciones científicas y conferenciante internacional'
        ]
    ],
    2 => [
        'nombre' => 'Dr. Juan Del Valle',
        'titulo' => 'Especialista en Traumatología Dental',
        'imagen' => './assets/img/doctores(2).png',
        'descripcion' => 'Referente en el manejo de traumas dentales y restauración de dientes severamente comprometidos.',
        'especialidad' => 'La Traumatología Dental es una especialidad dedicada al diagnóstico, prevención y tratamiento de las lesiones traumáticas que afectan a los dientes y tejidos de soporte. Los traumas dentales son una urgencia odontológica que requiere atención inmediata para preservar las piezas afectadas y prevenir complicaciones a largo plazo.',
        'tratamientos' => [
            'Fracturas coronales y radiculares',
            'Luxaciones dentales',
            'Avulsiones (dientes completamente extraídos del alveolo)',
            'Reimplantes dentales',
            'Revascularización pulpar',
            'Tratamiento de reabsorciones radiculares post-traumáticas'
        ],
        'formacion' => [
            'Director del Máster de Endodoncia microscópica y cirugía apical de la Universidad Rey Juan Carlos',
            'Profesor del International Dental Institute (Palm Beach, Florida, EEUU)',
            'Máster de Endodoncia, Southern Mississippi University (USM)',
            'Miembro de la International Association of Dental Traumatology',
            'Investigador en técnicas regenerativas aplicadas a dientes traumatizados'
        ]
    ]
];

if (!$doctorId || !isset($doctores[$doctorId])) {
    header('Location: index.php');
    exit;
}

$doctor = $doctores[$doctorId];
?>

<div class="main-content">
<div class="section hero-small servicio-hero page-transition">
    <div class="container">
        <h1 class="page-transition delay-1"><?php echo $doctor['nombre']; ?></h1>
        <h2 class="page-transition delay-2"><?php echo $doctor['titulo']; ?></h2>
    </div>
</div>

<div class="section">
    <div class="container-card">
        <div class="especialidad-perfil">
            <div class="especialidad-imagen page-transition delay-1">
                <img src="<?php echo $doctor['imagen']; ?>" alt="<?php echo $doctor['nombre']; ?>">
                <div class="img-overlay"></div>
            </div>
            <div class="especialidad-info page-transition delay-2">
                <h3><?php echo $doctor['nombre']; ?></h3>
                <p class="especialidad-descripcion"><?php echo $doctor['descripcion']; ?></p>
                <p class="especialidad-detalle"><?php echo $doctor['especialidad']; ?></p>
                
                <div class="especialidad-tratamientos page-transition delay-3">
                    <h4>Tratamientos especializados</h4>
                    <ul>
                        <?php foreach ($doctor['tratamientos'] as $tratamiento): ?>
                            <li><?php echo $tratamiento; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="especialidad-formacion">
                    <h4>Formación y trayectoria</h4>
                    <ul>
                        <?php foreach ($doctor['formacion'] as $item): ?>
                            <li><?php echo $item; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="especialidad-cta">
            <p>Para tratamientos específicos con el <?php echo $doctor['nombre']; ?>, solicite una cita previa</p>
            <a href="index.php?page=citaciones" class="btn btn-outline btn-lg">SOLICITAR CITA</a>
        </div>
        
        <div class="otros-especialistas">
            <h3>Nuestros especialistas</h3>
            <div class="especialistas-links">
                <?php foreach ($doctores as $id => $doc): ?>
                    <?php if ($id != $doctorId): ?>
                        <a href="index.php?page=especialidad&doctor=<?php echo $id; ?>" class="btn btn-light">
                            <?php echo $doc['nombre']; ?> - <?php echo $doc['titulo']; ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</div> 