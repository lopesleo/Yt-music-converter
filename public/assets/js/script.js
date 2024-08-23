// public/assets/js/script.js

document.addEventListener('DOMContentLoaded', () => {
    const title = document.querySelector('.main-title');
    const colors = [
        { r: 255, g: 58, b: 58 }, // #ff3a3a
        { r: 171, g: 34, b: 46 }, // #AB222E
        { r: 122, g: 25, b: 33 }  // #7A1921
    ];
    
    let startTime = null;
    const duration = 10000; // Duração total da transição em ms
    const interval = 50; // Intervalo de atualização em ms

    function interpolateColor(color1, color2, factor) {
        const r = Math.round(color1.r + (color2.r - color1.r) * factor);
        const g = Math.round(color1.g + (color2.g - color1.g) * factor);
        const b = Math.round(color1.b + (color2.b - color1.b) * factor);
        return 'rgb(' + r + ', ' + g + ', ' + b + ')';
    }

    function updateColor(timestamp) {
        if (!startTime) startTime = timestamp;
        const elapsed = timestamp - startTime;
        const progress = (elapsed % duration) / duration;
        
        const colorIndex = Math.floor(progress * (colors.length - 1));
        const factor = (progress * (colors.length - 1)) % 1;
        const color1 = colors[colorIndex];
        const color2 = colors[colorIndex + 1];
        
        title.style.color = interpolateColor(color1, color2, factor);

        requestAnimationFrame(updateColor);
    }

    requestAnimationFrame(updateColor);

    // Adiciona o indicador de carregamento ao enviar o formulário
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('loading').style.display = 'flex';
    });
});
