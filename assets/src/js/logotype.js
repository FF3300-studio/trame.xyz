document.addEventListener('DOMContentLoaded', () => {
    const logotype = document.querySelector('.logotype');
    if (!logotype) return;

    const fonts = [
        'GTL Trame 1',
        'GTL Trame 2',
        'GTL Trame 3',
        'GTL Trame 4',
        'GTL Trame 5',
        'GTL Trame 6'
    ];

    let currentFontIndex = 0;

    function animateLogotype() {
        // Cycle font family
        currentFontIndex = (currentFontIndex + 1) % fonts.length;
        const font = fonts[currentFontIndex];
        
        // Random weight between 50 and 200
        const weight = Math.floor(Math.random() * (200 - 50 + 1)) + 50;

        logotype.style.fontFamily = `"${font}", sans-serif`;
        logotype.style.fontVariationSettings = `"wght" ${weight}`;
    }

    // Run animation every 1000ms (1 second)
    setInterval(animateLogotype, 1000);
});
