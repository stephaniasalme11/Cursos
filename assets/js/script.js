document.addEventListener('DOMContentLoaded', function() {
    // Filtrado de cursos por categoría
    const filtros = document.querySelectorAll('.filtros .etiqueta');
    const cursos = document.querySelectorAll('.curso-card');
    
    if (filtros.length && cursos.length) {
        filtros.forEach(filtro => {
            filtro.addEventListener('click', function() {
                // Remover activo de todos los filtros
                filtros.forEach(f => f.classList.remove('activa'));
                // Añadir activo al filtro clickeado
                this.classList.add('activa');
                
                const categoria = this.getAttribute('data-categoria');
                
                // Mostrar cursos según filtro
                cursos.forEach(curso => {
                    if (categoria === 'todas' || curso.getAttribute('data-categoria') === categoria) {
                        curso.style.display = 'flex';
                    } else {
                        curso.style.display = 'none';
                    }
                });
            });
        });
    }
    
    // Validación de formularios
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let valid = true;
            const inputs = this.querySelectorAll('input[required]');
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.style.borderColor = 'var(--danger)';
                    
                    // Crear mensaje de error si no existe
                    if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-msg')) {
                        const errorMsg = document.createElement('p');
                        errorMsg.className = 'error-msg';
                        errorMsg.style.color = 'var(--danger)';
                        errorMsg.style.fontSize = '0.8rem';
                        errorMsg.style.marginTop = '5px';
                        errorMsg.textContent = 'Este campo es requerido';
                        input.parentNode.insertBefore(errorMsg, input.nextSibling);
                    }
                } else {
                    input.style.borderColor = '';
                    // Eliminar mensaje de error si existe
                    if (input.nextElementSibling && input.nextElementSibling.classList.contains('error-msg')) {
                        input.nextElementSibling.remove();
                    }
                }
            });
            
            if (!valid) {
                e.preventDefault();
            }
        });
    });
    
    // Smooth scrolling para anclas
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});