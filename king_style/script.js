function waitForElement(selector, timeout = 3000) {
    return new Promise((resolve, reject) => {
        const el = document.querySelector(selector);
        if (el) return resolve(el);

        const observer = new MutationObserver((mutations, obs) => {
            const e = document.querySelector(selector);
            if (e) {
                obs.disconnect();
                resolve(e);
            }
        });

        observer.observe(document.documentElement, { childList: true, subtree: true });

        if (timeout) {
            setTimeout(() => {
                observer.disconnect();
                reject(new Error('Timeout waiting for ' + selector));
            }, timeout);
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {

    waitForElement('.search-bar input', 2000).then((searchInput) => {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            console.log('Buscando:', searchTerm);
        });
    }).catch(()=> {
    });

    waitForElement('#userIcon', 2000).then((icon) => {
        const menu = document.getElementById("dropdownMenu");
        if (!menu) return;

        icon.addEventListener("click", (e) => {
            e.stopPropagation();
            menu.style.display = menu.style.display === "block" ? "none" : "block";
        });

        document.addEventListener("click", function (e) {
            if (!icon.contains(e.target) && !menu.contains(e.target)) {
                menu.style.display = "none";
            }
        });
    }).catch(()=> {
    });

    waitForElement('.carousel-track', 2000).then(() => {
        const track = document.querySelector(".carousel-track");
        const slides = Array.from(document.querySelectorAll(".slide"));
        const nextBtn = document.querySelector(".next");
        const prevBtn = document.querySelector(".prev");
        const dots = Array.from(document.querySelectorAll(".dot"));

        if (!track || slides.length === 0 || dots.length === 0) return;

        let currentIndex = 0;
        let autoplayInterval = null;

        function updateCarousel() {
            if (!track) return;
            track.style.transform = `translateX(-${currentIndex * 100}%)`;

            dots.forEach((d, i) => {
                d.classList.toggle("active", i === currentIndex);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener("click", () => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateCarousel();
                resetAutoplay();
            });
        }
        if (prevBtn) {
            prevBtn.addEventListener("click", () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                updateCarousel();
                resetAutoplay();
            });
        }

        dots.forEach((dot, i) => {
            dot.addEventListener("click", () => {
                currentIndex = i;
                updateCarousel();
                resetAutoplay();
            });
        });

        function startAutoplay() {
            if (autoplayInterval) return;
            autoplayInterval = setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateCarousel();
            }, 5000);
        }

        function stopAutoplay() {
            if (!autoplayInterval) return;
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }

        function resetAutoplay() {
            stopAutoplay();
            startAutoplay();
        }

        const carouselEl = document.querySelector('.hero-carousel');
        if (carouselEl) {
            carouselEl.addEventListener('mouseenter', stopAutoplay);
            carouselEl.addEventListener('mouseleave', startAutoplay);
        }
        updateCarousel();
        startAutoplay();

    }).catch(() => {
    });
}); 

document.addEventListener("DOMContentLoaded", () => {
    const icon = document.getElementById("userIcon");
    const menu = document.getElementById("dropdownMenu");

    if (icon) {
        icon.addEventListener("click", () => {
            menu.classList.toggle("show-dropdown");
        });
    }

    document.addEventListener("click", (e) => {
        if (!e.target.closest(".user-dropdown")) {
            menu?.classList.remove("show-dropdown");
        }
    });
});

const modalAgregar = document.getElementById('modalAgregar');
document.getElementById('btnAgregar').onclick = () => { modalAgregar.style.display = 'block'; }

function cerrarModalAgregar(){
    modalAgregar.style.display = 'none';
    document.getElementById('formAgregar').reset();
    document.getElementById('mensajeAgregar').textContent = '';
}

window.addEventListener('click', e => { if(e.target==modalAgregar) cerrarModalAgregar(); });

function agregarProducto(){
    const formData = new FormData(document.getElementById('formAgregar'));
    fetch('agregar_producto.php', {
        method:'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('mensajeAgregar');
        msg.textContent = data.message;
        msg.style.color = data.success ? 'green' : 'red';
        if(data.success) setTimeout(()=>location.reload(), 1200);
    })
    .catch(err => console.error(err));
}

const pass = document.getElementById("pass");
const pass2 = document.getElementById("pass2");
const btn = document.getElementById("submitBtn");

const errLen = document.getElementById("error-length");
const errNum = document.getElementById("error-number");
const errSpace = document.getElementById("error-space");
const errMatch = document.getElementById("pass-error-js");

function validar() {
    let valid = true;
    const value = pass.value;

    errLen.style.display = "none";
    errNum.style.display = "none";
    errSpace.style.display = "none";
    errMatch.style.display = "none";

    pass.classList.remove("input-error");
    pass2.classList.remove("input-error");

    if (/\s/.test(value)) {
        errSpace.style.display = "block";
        valid = false;
        pass.classList.add("input-error");
    }

    if (!/\d/.test(value)) {
        errNum.style.display = "block";
        valid = false;
        pass.classList.add("input-error");
    }

    if (value.length < 8) {
        errLen.style.display = "block";
        valid = false;
        pass.classList.add("input-error");
    }


    if (pass.value !== pass2.value || pass2.value.length === 0) {
        errMatch.style.display = "block";
        pass2.classList.add("input-error");
        valid = false;
    } else {
        pass2.classList.remove("input-error");
    }

    btn.disabled = !valid;
}

pass.addEventListener("input", validar);
pass2.addEventListener("input", validar);


document.addEventListener("DOMContentLoaded", () => {
    const icon = document.getElementById("userIcon");
    const menu = document.getElementById("dropdownMenu");

    if (icon) {
        icon.addEventListener("click", () => {
            menu.classList.toggle("show-dropdown");
        });
    }

    document.addEventListener("click", (e) => {
        if (!e.target.closest(".user-dropdown")) {
            menu?.classList.remove("show-dropdown");
        }
    });
});

const modal = document.getElementById('modal');
const formEditar = document.getElementById('formEditar');
const editImagenInput = document.getElementById('editImagen');
const editImagenPreview = document.getElementById('editImagenPreview');

function abrirModal(producto){
    modal.style.display = 'block';
    document.getElementById('editId').value = producto.id;
    document.getElementById('editNombre').value = producto.nombre;
    document.getElementById('editCategoria').value = producto.categoria;
    document.getElementById('editDescripcion').value = producto.descripcion;
    document.getElementById('editPrecio').value = producto.precio;
    document.getElementById('editStock').value = producto.stock;
    editImagenPreview.src = producto.imagen;
    document.getElementById('mensajeModal').textContent = '';
}

editImagenInput.addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = e => editImagenPreview.src = e.target.result;
        reader.readAsDataURL(file);
    }
});

function cerrarModal() { modal.style.display = 'none'; formEditar.reset(); }

function guardarCambios(){
    const formData = new FormData(formEditar);
    fetch('update_stock.php', { method:'POST', body: formData })
    .then(res=>res.json())
    .then(data=>{
        const msg = document.getElementById('mensajeModal');
        msg.textContent = data.message;
        msg.style.color = data.success ? 'green' : 'red';
        if(data.success) setTimeout(()=>location.reload(),1200);
    }).catch(err=>console.error(err));
}

function eliminarProducto(id){
    if(!confirm('¿Seguro que querés eliminar este producto?')) return;
    fetch('borrar_producto.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`id=${id}`
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.success) document.getElementById(`fila-${id}`).remove();
        else alert('Error: '+data.message);
    }).catch(err=>console.error(err));
}


window.onclick = e => { if(e.target==modal) cerrarModal(); }


