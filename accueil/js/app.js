function showHiddenSection(hiddenSection, buttonIcon) {
    const isHidden = hiddenSection.classList.toggle("hide");
    
    }
    const filterButton = document.querySelector(".filterButton");
    const closeIcon = document.querySelector(".closeIcon");
    const filter = document.querySelector(".filtre");
    
    filterButton.addEventListener('click', () => {
        filter.classList.toggle("mobileMenu");
    });
    
    closeIcon.addEventListener('click', () => {
        filter.classList.toggle("removeMobileMenu");
    });
    