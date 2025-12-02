/* CUSTOM TEXT EFFECTS: SELECTION & UNDERLINE */

(function() {
  // --- CONFIGURATION ---
  const CONFIG = {
    selection: {
      className: 'selection-layer',
      // Color is handled by CSS class
    },
    underline: {
      className: 'underline-layer',
      // Color is handled by CSS class
    }
  };

  // --- SHARED UTILITIES ---

  // Generate a random letter from a-z
  function getRandomLetter() {
    const letters = 'abcdefghijklmnopqrstuvwxyz';
    return letters[Math.floor(Math.random() * letters.length)];
  }

  // Create a visual layer for a specific rectangle
  function createLayer(rect, letter, className, fontSizeOverride = null) {
    const layer = document.createElement('div');
    layer.className = className;
    
    // Determine font size
    // Use rect height to scale font, or override if provided
    const fontSize = fontSizeOverride || (rect.height * 0.9); 
    const charWidth = fontSize * 0.6; // Approx char width
    const numChars = Math.ceil(rect.width / charWidth) + 2;
    
    layer.textContent = letter.repeat(numChars);
    
    // Position the layer
    // We use absolute positioning relative to document/body for underlines
    // and fixed for selection (usually) but let's standardize on absolute + scroll offset for underlines
    // For selection, fixed is easier as it follows viewport, but we need to match getClientRects
    
    // Let's use fixed for everything to be consistent with getClientRects which returns viewport coords
    // BUT for underlines that scroll with page, absolute relative to document is better, 
    // OR fixed that updates on scroll. 
    // The previous selection implementation used fixed.
    
    if (className === CONFIG.selection.className) {
        layer.style.position = 'fixed';
        layer.style.left = rect.left + 'px';
        layer.style.top = rect.top + 'px';
    } else {
        // For underlines, we want them to scroll with the page without constant JS updates if possible.
        // But getClientRects is viewport relative.
        // Let's use absolute + window.scrollY/X
        layer.style.position = 'absolute';
        layer.style.left = (rect.left + window.scrollX) + 'px';
        layer.style.top = (rect.top + window.scrollY) + 'px';
    }

    layer.style.width = rect.width + 'px';
    layer.style.height = rect.height + 'px';
    layer.style.fontSize = fontSize + 'px';
    layer.style.pointerEvents = 'none'; // Ensure layer doesn't block clicks/scrolls
    layer.style.zIndex = '0'; // Ensure it's behind text (if possible, though fixed/abs might sit on top depending on context)
    
    document.body.appendChild(layer);
    return layer;
  }

  // --- SELECTION LOGIC ---
  
  let selectionLayers = [];
  let isSelecting = false;
  let currentSelectionLetter = '';

  function updateSelection() {
    // Remove existing layers
    selectionLayers.forEach(layer => layer.remove());
    selectionLayers = [];

    const selection = window.getSelection();
    if (!selection.rangeCount || selection.isCollapsed) {
      return;
    }

    // New selection -> new letter
    if (!isSelecting) {
      currentSelectionLetter = getRandomLetter();
      isSelecting = true;
    }

    const range = selection.getRangeAt(0);
    const rects = range.getClientRects();

    for (let i = 0; i < rects.length; i++) {
      const rect = rects[i];
      if (rect.width > 0 && rect.height > 0) {
        const layer = createLayer(rect, currentSelectionLetter, CONFIG.selection.className);
        selectionLayers.push(layer);
      }
    }
  }

  function clearSelection() {
    selectionLayers.forEach(layer => layer.remove());
    selectionLayers = [];
    isSelecting = false;
    currentSelectionLetter = '';
  }

  // --- UNDERLINE LOGIC ---

  let underlineLayers = [];

  function updateUnderlines() {
    // Clear existing underlines
    underlineLayers.forEach(layer => layer.remove());
    underlineLayers = [];

    // Find all elements to underline
    // 1. <u> tags
    // 2. Elements with style="text-decoration: underline"
    // 3. Elements with class that might have underline? (Let's stick to explicit ones for now)
    
    const uTags = document.querySelectorAll('u');
    const styledTags = document.querySelectorAll('[style*="text-decoration: underline"]');
    // Also check for computed style? No, too heavy. Stick to explicit tags/styles.
    
    const elements = [...uTags, ...styledTags];

    elements.forEach(el => {
        // Generate a stable random letter for this element? 
        // Or random every time? User said "random glyph", usually implies stable per session or per render.
        // Let's generate one per element. We can store it on the element to keep it stable during resize.
        
        let letter = el.dataset.underlineLetter;
        if (!letter) {
            letter = getRandomLetter();
            el.dataset.underlineLetter = letter;
        }

        // Get rects (handles multi-line)
        const rects = el.getClientRects();
        
        for (let i = 0; i < rects.length; i++) {
            const rect = rects[i];
            if (rect.width > 0 && rect.height > 0) {
                // For underline, we want it BEHIND the text.
                // The layer has z-index: 0, text usually has auto or higher.
                // We might need to ensure text has z-index if it's not working.
                
                const layer = createLayer(rect, letter, CONFIG.underline.className);
                underlineLayers.push(layer);
            }
        }
        
        // Hide the native underline if possible?
        // User said "using the same style", implying replacement or overlay.
        // If we overlay, the native underline is still there.
        // Let's force transparent color for text-decoration if we can.
        el.style.textDecorationColor = 'transparent';
    });
  }

  // --- EVENT LISTENERS ---

  // Selection events
  document.addEventListener('mouseup', () => setTimeout(updateSelection, 10));
  document.addEventListener('mousedown', clearSelection);
  document.addEventListener('selectionchange', () => {
    const selection = window.getSelection();
    if (selection.isCollapsed) clearSelection();
    else updateSelection();
  });

  // Scroll & Resize
  window.addEventListener('scroll', (e) => {
    // Ignore scroll events from Swiper to avoid performance issues or conflicts
    if (e.target && e.target.classList && (e.target.classList.contains('swiper') || e.target.closest('.swiper'))) {
      return;
    }
    
    if (selectionLayers.length > 0) updateSelection();
    // Underlines are absolute, so they scroll with page naturally. No update needed for scroll!
  }, true);

  window.addEventListener('resize', () => {
    if (selectionLayers.length > 0) updateSelection();
    updateUnderlines(); // Underlines need recalc on resize (text reflow)
  });

  document.addEventListener('click', (e) => {
    setTimeout(() => {
      const selection = window.getSelection();
      if (selection.isCollapsed) clearSelection();
    }, 10);
  });

  // Initial load
  window.addEventListener('load', updateUnderlines);
  // Also run immediately in case DOM is ready
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    updateUnderlines();
  }
  // And on DOMContentLoaded
  document.addEventListener('DOMContentLoaded', updateUnderlines);

})();
