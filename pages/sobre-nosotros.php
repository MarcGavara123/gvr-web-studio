<?php
require_once '../includes/config.php';

$page_title = "Sobre Nosotros - GVR Web Studio";

include '../includes/header.php';
?>

<!-- HERO DE PÁGINA -->
<section class="page-hero">
    <div class="container">
        <h1>Sobre Nosotros</h1>
        <p>Descubre nuestra manera de trabajar</p>
    </div>
</section>

<!-- INTRO -->
<section class="about-intro">
    <div class="container">
        <div class="about-intro-content">
            <div class="about-intro-text">
                <h2>Más que una agencia, un aliado estratégico</h2>
                <p>En GVR Web Studio creemos que cada negocio merece una presencia online única y profesional. Trabajamos de forma cercana para entender tus necesidades y transformarlas en soluciones digitales efectivas.</p>
                <p>No creemos en plantillas prefabricadas. Cada proyecto es único y recibe la atención que merece, desde el primer boceto hasta el lanzamiento final.</p>
            </div>
            <div class="about-intro-image">
                <img src="../assets/images/sobrenos.png" alt="Sobre GVR Web Studio">
            </div>
        </div>
    </div>
</section>

<!-- MISIÓN, VISIÓN, VALORES -->
<section class="mission-vision">
    <div class="container">
        <div class="mv-grid">
            <div class="mv-card">
                <div class="mv-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Misión</h3>
                <p>Ayudar a negocios y emprendedores a destacar en el mundo digital mediante soluciones creativas, funcionales y adaptadas a sus necesidades reales.</p>
            </div>
            <div class="mv-card">
                <div class="mv-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Visión</h3>
                <p>Convertirnos en un referente en diseño y desarrollo web, reconocidos por la calidad de nuestro trabajo y la cercanía con nuestros clientes.</p>
            </div>
            <div class="mv-card">
                <div class="mv-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Valores</h3>
                <ul>
                    <li>Creatividad sin límites</li>
                    <li>Compromiso con el cliente</li>
                    <li>Calidad en cada detalle</li>
                    <li>Pasión por el diseño</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CÓMO TRABAJAMOS -->
<section class="how-we-work">
    <div class="container">
        <div class="section-header">
            <h2>¿Cómo trabajamos?</h2>
            <p>Un proceso claro y transparente para llevar tu idea a la realidad</p>
        </div>
        <div class="process-steps">
            <div class="step">
                <div class="step-number">01</div>
                <h3>Análisis</h3>
                <p>Escuchamos tu idea, analizamos tu mercado y definimos los objetivos del proyecto.</p>
            </div>
            <div class="step">
                <div class="step-number">02</div>
                <h3>Propuesta</h3>
                <p>Presentamos una propuesta detallada con cronograma, presupuesto y primeras ideas creativas.</p>
            </div>
            <div class="step">
                <div class="step-number">03</div>
                <h3>Diseño</h3>
                <p>Creamos el diseño visual, te mostramos prototipos y realizamos los ajustes necesarios.</p>
            </div>
            <div class="step">
                <div class="step-number">04</div>
                <h3>Desarrollo</h3>
                <p>Programamos y construimos tu proyecto con las mejores tecnologías.</p>
            </div>
            <div class="step">
                <div class="step-number">05</div>
                <h3>Lanzamiento</h3>
                <p>Realizamos pruebas, optimizamos y publicamos tu proyecto.</p>
            </div>
            <div class="step">
                <div class="step-number">06</div>
                <h3>Soporte</h3>
                <p>Te acompañamos después del lanzamiento con formación y mantenimiento.</p>
            </div>
        </div>
    </div>
</section>

<!-- POR QUÉ ELEGIRNOS -->
<section class="why-us">
    <div class="container">
        <div class="section-header">
            <h2>¿Por qué elegir GVR Web Studio?</h2>
            <p>Lo que nos hace diferentes</p>
        </div>
        <div class="features-grid">
            <div class="feature-item">
                <i class="fa-solid fa-paintbrush"></i>
                <h3>Diseño único</h3>
                <p>Nunca usamos plantillas. Cada diseño es exclusivo para tu marca.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-mobile-alt"></i>
                <h3>Totalmente responsive</h3>
                <p>Tus clientes tendrán la mejor experiencia en cualquier dispositivo.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-chart-line"></i>
                <h3>Enfoque en resultados</h3>
                <p>Diseñamos pensando en conversiones, no solo en estética.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-headset"></i>
                <h3>Soporte continuo</h3>
                <p>No desaparecemos después de entregar. Estamos para ayudarte.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-clock"></i>
                <h3>Entregas a tiempo</h3>
                <p>Cumplimos los plazos acordados sin comprometer la calidad.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-hand-holding-heart"></i>
                <h3>Cercanía y confianza</h3>
                <p>Trato personalizado y comunicación clara en todo momento.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2>¿Hablamos de tu proyecto?</h2>
            <p>Cuéntanos tu idea y te ayudaremos a hacerla realidad</p>
            <a href="contacto.php" class="btn btn-primary btn-large">Contáctanos</a>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>