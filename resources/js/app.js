import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const botonesSiguiente = document.getElementsByClassName('boton-siguiente');

    for (const botonSiguiente of botonesSiguiente) {
        botonSiguiente.addEventListener('click', function () {
            const imgElement = this.parentNode.querySelector('img');
            const imgs = Object.values(JSON.parse(imgElement.getAttribute('data-img') || '[]'));

            if (imgs.length === 0) {
                return;
            }

            let currentImg = parseInt(imgElement.getAttribute('current-img'), 10);
            currentImg++;

            if (currentImg >= imgs.length) {
                currentImg = 0;
            }

            const img = '/storage/Fotos/' + imgElement.getAttribute('car-id') + '/' + imgs[currentImg];

            imgElement.setAttribute('src', img);
            imgElement.setAttribute('current-img', currentImg);
        });
    }

    const botonesAnterior = document.getElementsByClassName('boton-anterior');

    for (const botonAnterior of botonesAnterior) {
        botonAnterior.addEventListener('click', function () {
            const imgElement = this.parentNode.querySelector('img');
            const imgs = Object.values(JSON.parse(imgElement.getAttribute('data-img') || '[]'));

            if (imgs.length === 0) {
                return;
            }

            let currentImg = parseInt(imgElement.getAttribute('current-img'), 10);
            currentImg--;

            if (currentImg < 0) {
                currentImg = imgs.length - 1;
            }

            const carId = imgElement.getAttribute('car-id');
            const imgPath = '/storage/Fotos/' + carId + '/' + imgs[currentImg];

            imgElement.setAttribute('src', imgPath);
            imgElement.setAttribute('current-img', currentImg);
        });
    }
});
