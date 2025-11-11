<?php
require_once 'layouts/header.php';
?>

<div class="card shadow-sm">
    <div class="card-body p-5">
        <h2 class="card-title text-center mb-4">Preguntas Frecuentes (FAQ)</h2>

        <div class="accordion" id="accordionFAQ">

            <!-- Pregunta 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        ¿Qué son las cuentas compartidas de Steam?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        Una cuenta compartida de Steam es una cuenta estándar de Steam que contiene uno o varios juegos comprados legalmente. En lugar de comprar el juego a precio completo, adquieres el acceso a nuestra cuenta para poder descargar y jugar a esos juegos. Varias personas utilizan la misma cuenta, pero siguiendo nuestras instrucciones, la experiencia de juego es individual y segura. Es la forma más económica de disfrutar de los mejores títulos.
                    </div>
                </div>
            </div>

            <!-- Pregunta 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        ¿Cómo se juega en ellas?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        Es muy sencillo. Una vez realizada la compra, te proporcionaremos un nombre de usuario y una contraseña. Debes iniciar sesión con esos datos en tu cliente de Steam. La parte más importante es que, para poder jugar sin interrupciones, deberás poner Steam en <strong>"Modo Desconectado"</strong> una vez que el juego esté descargado. Te entregaremos una guía detallada con el paso a paso para asegurar una experiencia de juego perfecta.
                    </div>
                </div>
            </div>

            <!-- Pregunta 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        ¿Qué pasa si la cuenta es baneada o "se cae"?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        La seguridad de nuestras cuentas es nuestra máxima prioridad. Sin embargo, pueden ocurrir dos situaciones:
                        <ul>
                            <li><strong>Si el problema es nuestra responsabilidad</strong> (por ejemplo, un fallo en nuestras credenciales), te proporcionaremos acceso a una cuenta de reemplazo o un reembolso completo, según nuestra política de reembolsos.</li>
                            <li><strong>Si el baneo o restricción es causado por el mal uso de un usuario</strong> (como usar trampas o violar los términos de servicio), esa persona pierde el acceso inmediatamente y sin reembolso. Para el resto de los usuarios en la cuenta, trabajaremos para restaurar el servicio lo antes posible o migrarlos a una nueva cuenta segura.</li>
                        </ul>
                        Nuestro objetivo es garantizar la continuidad de tu juego.
                    </div>
                </div>
            </div>

            <!-- Pregunta 4 (anterior Pregunta 1) -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        ¿Cómo recibo los datos de la cuenta después de la compra?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <strong>¡La entrega es inmediata!</strong> Una vez que tu pago se procesa con éxito a través de PayPal, los detalles de la cuenta (usuario y contraseña), junto con las instrucciones de uso, se mostrarán en tu sección de "Mis Pedidos".
                    </div>
                </div>
            </div>

            <!-- Pregunta 5 (anterior Pregunta 2) -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        ¿Es seguro comprar aquí?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        Absolutamente. Utilizamos la pasarela de pagos de PayPal, una de las más seguras del mundo. Nosotros nunca vemos ni almacenamos la información de tu tarjeta de crédito. Todas las cuentas son verificadas por nuestro equipo para asegurar su correcto funcionamiento.
                    </div>
                </div>
            </div>

            <!-- Pregunta 6 (Nueva) -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        ¿Qué hago si la cuenta que compré pide un código de seguridad o acceso?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        <p>
                            ¡No te preocupes! Algunas de nuestras cuentas, especialmente las que incluyen juegos con sistemas de seguridad como <strong>Denuvo</strong>, requieren un código de acceso para el primer inicio de sesión. Esto se debe a que solo permiten un número limitado de activaciones de dispositivos por día (generalmente 5).
                        </p>
                        <p>
                            Para garantizar un acceso ordenado y exitoso, necesitas contactarnos para recibir tu código de activación.
                        </p>
                        <p class="fw-bold">
                            Por favor, escríbenos a través de nuestro <a href="https://wa.link/kvzhpj">WhatsApp</a> dentro de nuestro horario de atención para solicitar tu código:
                        </p>
                        <div class="alert alert-warning text-center">
                            <strong>Horario de Atención para Códigos:</strong><br>
                            Lunes a Domingo, de <strong>8:00 AM a 16:00 PM</strong> (hora de Ecuador, GTM-5).
                        </div>
                        <p>
                            Uno de nuestros agentes te proporcionará el código lo más rápido posible dentro de ese horario para que puedas empezar a jugar. ¡Agradecemos tu paciencia!
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
require_once 'layouts/footer.php';
?>