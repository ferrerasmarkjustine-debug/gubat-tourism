<!-- Floating Navigation Dock (Bottom-Right Corner) -->
<div id="floating-category-dock" class="d-flex flex-column align-items-center" aria-label="Category Navigation">
    
    <!-- 1. Beach & Surfing -->
    <div class="dock-item-wrapper position-relative my-1">
        <button type="button" class="dock-btn dock-btn-beach" data-target="#beach-surfing-section" aria-label="Beach & Surfing">
            <i class="bi bi-tsunami"></i>
        </button>
        <span class="dock-tooltip">Beach & Surfing</span>
    </div>

    <!-- 2. Churches -->
    <div class="dock-item-wrapper position-relative my-1">
        <button type="button" class="dock-btn dock-btn-church" data-target="#churches-section" aria-label="Churches">
            <i class="bi bi-bank"></i>
        </button>
        <span class="dock-tooltip">Churches</span>
    </div>

    <!-- 3. History -->
    <div class="dock-item-wrapper position-relative my-1">
        <button type="button" class="dock-btn dock-btn-history" data-target="#history-section" aria-label="History">
            <i class="bi bi-hourglass-split"></i>
        </button>
        <span class="dock-tooltip">History</span>
    </div>

    <!-- 4. Nature & Ecotourism -->
    <div class="dock-item-wrapper position-relative my-1">
        <button type="button" class="dock-btn dock-btn-nature" data-target="#nature-ecotourism-section" aria-label="Nature & Ecotourism">
            <i class="bi bi-tree-fill"></i>
        </button>
        <span class="dock-tooltip">Nature &amp; Eco</span>
    </div>

    <!-- 5. Local Crafts -->
    <div class="dock-item-wrapper position-relative my-1">
        <button type="button" class="dock-btn dock-btn-crafts" data-target="#local-crafts-section" aria-label="Local Crafts">
            <i class="bi bi-tools"></i>
        </button>
        <span class="dock-tooltip">Crafts</span>
    </div>
</div>

<style>
/* Floating Dock Capsule Styles */
#floating-category-dock {
    position: fixed;
    bottom: 25px;
    right: 25px;
    z-index: 1040;
    background: rgba(186, 230, 253, 0.88);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 2px solid rgba(255, 255, 255, 0.7);
    box-shadow: 0 10px 30px rgba(11, 37, 69, 0.22);
    border-radius: 50px;
    padding: 10px 8px;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

#floating-category-dock:hover {
    box-shadow: 0 14px 35px rgba(11, 37, 69, 0.28);
    background: rgba(186, 230, 253, 0.95);
}

.dock-item-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.dock-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: 2px solid transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    cursor: pointer;
    background: #ffffff;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.dock-btn:hover {
    transform: scale(1.14);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.16);
}

.dock-btn:active {
    transform: scale(0.96);
}

/* Category Specific Button Colors (from Category Cards) */
.dock-btn-beach {
    background-color: #e0f2fe;
    color: #0284c7;
    border-color: rgba(2, 132, 199, 0.25);
}
.dock-btn-beach:hover, .dock-btn-beach.active-dock {
    background-color: #0284c7;
    color: #ffffff;
    border-color: #0284c7;
    box-shadow: 0 4px 14px rgba(2, 132, 199, 0.4);
}

.dock-btn-church {
    background-color: #fef3c7;
    color: #d97706;
    border-color: rgba(217, 119, 6, 0.25);
}
.dock-btn-church:hover, .dock-btn-church.active-dock {
    background-color: #d97706;
    color: #ffffff;
    border-color: #d97706;
    box-shadow: 0 4px 14px rgba(217, 119, 6, 0.4);
}

.dock-btn-history {
    background-color: #fdf2e9;
    color: #92400e;
    border-color: rgba(146, 64, 14, 0.25);
}
.dock-btn-history:hover, .dock-btn-history.active-dock {
    background-color: #92400e;
    color: #ffffff;
    border-color: #92400e;
    box-shadow: 0 4px 14px rgba(146, 64, 14, 0.4);
}

.dock-btn-nature {
    background-color: #dcfce7;
    color: #16a34a;
    border-color: rgba(22, 163, 74, 0.25);
}
.dock-btn-nature:hover, .dock-btn-nature.active-dock {
    background-color: #16a34a;
    color: #ffffff;
    border-color: #16a34a;
    box-shadow: 0 4px 14px rgba(22, 163, 74, 0.4);
}

.dock-btn-crafts {
    background-color: #efebe9;
    color: #8D6E63;
    border-color: rgba(141, 110, 99, 0.25);
}
.dock-btn-crafts:hover, .dock-btn-crafts.active-dock {
    background-color: #8D6E63;
    color: #ffffff;
    border-color: #8D6E63;
    box-shadow: 0 4px 14px rgba(141, 110, 99, 0.4);
}

/* Hover Tooltip (Slides out to the left) */
.dock-tooltip {
    position: absolute;
    right: calc(100% + 12px);
    top: 50%;
    transform: translateY(-50%) translateX(6px);
    background: #0b2545;
    color: #ffffff;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 600;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.dock-tooltip::after {
    content: '';
    position: absolute;
    top: 50%;
    right: -5px;
    transform: translateY(-50%);
    border-width: 5px 0 5px 5px;
    border-style: solid;
    border-color: transparent transparent transparent #0b2545;
}

.dock-item-wrapper:hover .dock-tooltip {
    opacity: 1;
    transform: translateY(-50%) translateX(0);
}

@media (max-width: 576px) {
    #floating-category-dock {
        bottom: 18px;
        right: 14px;
        padding: 8px 6px;
    }
    .dock-btn {
        width: 42px;
        height: 42px;
        font-size: 1.15rem;
    }
    .dock-tooltip {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dockButtons = document.querySelectorAll('.dock-btn');
    const navOffset = 80;

    // Smooth scroll to target section with offset
    dockButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const targetSelector = this.getAttribute('data-target');
            const targetEl = document.querySelector(targetSelector);
            if (targetEl) {
                const elementPosition = targetEl.getBoundingClientRect().top + window.scrollY;
                const offsetPosition = elementPosition - navOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Scrollspy to highlight active dock button
    const sections = [
        { selector: '#beach-surfing-section', btnClass: '.dock-btn-beach' },
        { selector: '#churches-section', btnClass: '.dock-btn-church' },
        { selector: '#history-section', btnClass: '.dock-btn-history' },
        { selector: '#nature-ecotourism-section', btnClass: '.dock-btn-nature' },
        { selector: '#local-crafts-section', btnClass: '.dock-btn-crafts' }
    ];

    function updateActiveDock() {
        const scrollY = window.scrollY + navOffset + 150;
        let activeFound = false;

        for (let i = sections.length - 1; i >= 0; i--) {
            const sec = document.querySelector(sections[i].selector);
            if (sec) {
                const top = sec.offsetTop;
                const height = sec.offsetHeight;
                if (scrollY >= top && scrollY < top + height) {
                    dockButtons.forEach(b => b.classList.remove('active-dock'));
                    const btn = document.querySelector(sections[i].btnClass);
                    if (btn) btn.classList.add('active-dock');
                    activeFound = true;
                    break;
                }
            }
        }

        if (!activeFound) {
            dockButtons.forEach(b => b.classList.remove('active-dock'));
        }
    }

    window.addEventListener('scroll', updateActiveDock, { passive: true });
    updateActiveDock();
});
</script>
