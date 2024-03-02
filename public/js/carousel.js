// Selecciona los elementos del DOM necesarios para la funcionalidad del carousel
const carousel = document.querySelector(".carousel");
const container = document.querySelector(".carousel-container");
const items = document.querySelectorAll(".carousel-item");
const itemCount = items.length;
let currentIndex = 0;

// Función para establecer la transformación CSS del carrusel
// Realiza un desplazamiento horizontal (a lo largo del eje X) para simular el efecto de deslizamiento de los elementos en el carrusel.
function setTransform() {
  const itemWidth = container.clientWidth;
  carousel.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
}

// Función para avanzar al siguiente elemento del carrusel
function next() {
  currentIndex = (currentIndex + 1) % itemCount;
  setTransform();
}

// Función para retroceder al elemento anterior del carrusel
function prev() {
  currentIndex = (currentIndex - 1 + itemCount) % itemCount;
  setTransform();
}

// Opcional: Avance automático del carrusel cada pocos segundos
setInterval(next, 3000);

// Agrega event listeners a los botones de navegación del carrusel
document.querySelector(".next-btn").addEventListener("click", next);
document.querySelector(".prev-btn").addEventListener("click", prev);

// Configuración inicial del carrusel
setTransform();
