document.querySelectorAll("#output a").forEach(function(link, index) {
    link.addEventListener("mouseover", function() {
        document.querySelectorAll("#output a").forEach(function(link) {
            link.classList.remove("active");
        });
        this.classList.add("active");
    });

    link.addEventListener("click", function(event) {
        event.preventDefault(); // Отменяем стандартное поведение перехода по ссылке
        setSelected(index); // Устанавливаем выбранную ссылку
        window.location.href = this.href; // Переходим по ссылке
    });
});

let selectedIndex = 0; // Индекс текущей выбранной ссылки

document.addEventListener('keydown', event => {
    const links = document.querySelectorAll("#output a");

    if (event.key === 'ArrowLeft') {
        selectedIndex = Math.max(0, selectedIndex - 1);
    } else if (event.key === 'ArrowRight') {
        selectedIndex = Math.min(links.length - 1, selectedIndex + 1);
    }

    setSelected(selectedIndex);
});

document.addEventListener("keydown", function(event) {
    const activeLink = document.querySelector("#output a.active");

    if (event.key === "Enter" && activeLink) {
        window.location.href = activeLink.href;
    }
});

function setSelected(index) {
    const links = document.querySelectorAll("#output a");
    
    links.forEach(function(link) {
        link.classList.remove("active");
    });

    links[index].classList.add("active");
}

