// animation de présentation //
window.addEventListener("scroll", () => {
    const photo = document.querySelector(".photo");
    const description = document.querySelector(".description");
    const windowHeight = window.innerHeight;
    const photoTop = photo.getBoundingClientRect().top;
    const descriptionTop = description.getBoundingClientRect().top;
    if (photoTop < windowHeight - 100) {
        photo.classList.add("show");
    }

    if (descriptionTop < windowHeight - 100) {
        description.classList.add("show");
    }
});