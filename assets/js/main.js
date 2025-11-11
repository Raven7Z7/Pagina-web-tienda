// =======================================================
// ===          LÓGICA DEL CARRITO DE COMPRAS (AJAX)   ===
// =======================================================
function initAddToCartForms() {
    const forms = document.querySelectorAll('.add-to-cart-form');
    
    forms.forEach(form => {
        if (form.dataset.ajaxAttached) return;

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('acciones_carrito.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                updateCartCounter(data.cartCount);
                showToastNotification(data.message, data.success);
            })
            .catch(error => {
                console.error('Error en AJAX:', error);
                showToastNotification('Hubo un error de conexión.', false);
            });
        });
        
        form.dataset.ajaxAttached = 'true';
    });
}

function updateCartCounter(count) {
    const cartCounter = document.getElementById('cart-counter');
    if (cartCounter) {
        cartCounter.textContent = count;
    }
}

function showToastNotification(message, isSuccess) {
    const toastElement = document.getElementById('liveToast');
    if (!toastElement) return;

    const toastBody = document.getElementById('toastBody');
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastElement, { delay: 3000 });

    toastElement.classList.remove('bg-success', 'bg-warning', 'text-white', 'text-dark');
    if (isSuccess) {
        toastElement.classList.add('bg-success', 'text-white');
    } else {
        toastElement.classList.add('bg-warning', 'text-dark');
    }

    toastBody.textContent = message;
    toastBootstrap.show();
}


// =======================================================
// ===   FUNCIONALIDAD DE BÚSQUEDA EN VIVO PARA EL CATÁLOGO   ===
// =======================================================
function initLiveSearch() {
    const searchInput = document.getElementById('searchInput');
    const productCols = document.querySelectorAll('.product-col');

    if (!searchInput) {
        return; // Si no hay barra de búsqueda en la página, no hacemos nada.
    }

    searchInput.addEventListener('keyup', function() {
        const searchTerm = searchInput.value.toLowerCase();

        productCols.forEach(function(col) {
            const titleElement = col.querySelector('.product-card-title');
            
            if (titleElement) {
                const titleText = titleElement.textContent.toLowerCase();

                if (titleText.includes(searchTerm)) {
                    col.style.display = 'block';
                } else {
                    col.style.display = 'none';
                }
            }
        });
    });
}


// =======================================================
// ===     INICIALIZADOR PRINCIPAL DE LA APLICACIÓN    ===
// =======================================================
document.addEventListener('DOMContentLoaded', function() {
    // Este es el ÚNICO punto de entrada. Llama a todas las funciones que se deben ejecutar al cargar la página.
    initAddToCartForms();
    initLiveSearch();
    initCountdown();
});

// =============================================
// ===   CONTADOR REGRESIVO PARA LA OFERTA   ===
// =============================================
function initCountdown() {
    const countdownElement = document.getElementById('countdown');
    if (!countdownElement) return;

    // ¡IMPORTANTE! La fecha final de la oferta. Formato: Mes Día, Año HH:MM:SS
    const countDownDate = new Date("2025-10-31T23:59:59").getTime();

    const interval = setInterval(function() {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        // Cálculos de tiempo
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Mostramos los resultados
        document.getElementById('days').innerText = days < 10 ? '0' + days : days;
        document.getElementById('hours').innerText = hours < 10 ? '0' + hours : hours;
        document.getElementById('minutes').innerText = minutes < 10 ? '0' + minutes : minutes;
        document.getElementById('seconds').innerText = seconds < 10 ? '0' + seconds : seconds;

        // Si la cuenta atrás termina
        if (distance < 0) {
            clearInterval(interval);
            countdownElement.innerHTML = '<h3 class="text-danger">¡La oferta ha terminado!</h3>';
        }
    }, 1000);
}