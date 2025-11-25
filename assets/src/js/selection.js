/* CUSTOM TEXT SELECTION WITH RANDOM LETTERS */

(function() {
  let selectionLayers = [];
  let isSelecting = false;
  let currentLetter = '';

  // Funzione per generare una lettera random da a-z
  function getRandomLetter() {
    const letters = 'abcdefghijklmnopqrstuvwxyz';
    return letters[Math.floor(Math.random() * letters.length)];
  }

  // Funzione per creare un layer di selezione
  function createSelectionLayer(rect, letter) {
    const layer = document.createElement('div');
    layer.className = 'selection-layer';
    
    // Usa l'altezza del rettangolo per determinare la dimensione del font
    // Questo assicura che le lettere si adattino alla dimensione del testo selezionato
    const fontSize = rect.height * 0.9; // Usa il 90% dell'altezza per un fit migliore
    const charWidth = fontSize * 0.6; // Stima approssimativa della larghezza del carattere
    const numChars = Math.ceil(rect.width / charWidth) + 2;
    
    // Ripeti la lettera per riempire lo spazio
    layer.textContent = letter.repeat(numChars);
    
    // Posiziona il layer
    layer.style.left = rect.left + 'px';
    layer.style.top = rect.top + 'px';
    layer.style.width = rect.width + 'px';
    layer.style.height = rect.height + 'px';
    layer.style.fontSize = fontSize + 'px';
    
    document.body.appendChild(layer);
    return layer;
  }

  // Funzione per aggiornare i layer di selezione
  function updateSelection() {
    // Rimuovi i layer esistenti
    selectionLayers.forEach(layer => layer.remove());
    selectionLayers = [];

    const selection = window.getSelection();
    if (!selection.rangeCount || selection.isCollapsed) {
      return;
    }

    // Se è una nuova selezione, genera una nuova lettera
    if (!isSelecting) {
      currentLetter = getRandomLetter();
      isSelecting = true;
    }

    // Ottieni tutti i rettangoli della selezione
    const range = selection.getRangeAt(0);
    const rects = range.getClientRects();

    // Crea un layer per ogni rettangolo
    for (let i = 0; i < rects.length; i++) {
      const rect = rects[i];
      if (rect.width > 0 && rect.height > 0) {
        const layer = createSelectionLayer(rect, currentLetter);
        selectionLayers.push(layer);
      }
    }
  }

  // Funzione per pulire la selezione
  function clearSelection() {
    selectionLayers.forEach(layer => layer.remove());
    selectionLayers = [];
    isSelecting = false;
    currentLetter = '';
  }

  // Event listeners
  document.addEventListener('mouseup', function() {
    setTimeout(updateSelection, 10);
  });

  document.addEventListener('mousedown', function() {
    clearSelection();
  });

  document.addEventListener('selectionchange', function() {
    const selection = window.getSelection();
    if (selection.isCollapsed) {
      clearSelection();
    } else {
      updateSelection();
    }
  });

  // Gestisci lo scroll
  window.addEventListener('scroll', function() {
    if (selectionLayers.length > 0) {
      updateSelection();
    }
  }, true);

  // Gestisci il resize della finestra
  window.addEventListener('resize', function() {
    if (selectionLayers.length > 0) {
      updateSelection();
    }
  });

  // Pulisci quando si clicca altrove
  document.addEventListener('click', function(e) {
    setTimeout(function() {
      const selection = window.getSelection();
      if (selection.isCollapsed) {
        clearSelection();
      }
    }, 10);
  });
})();
