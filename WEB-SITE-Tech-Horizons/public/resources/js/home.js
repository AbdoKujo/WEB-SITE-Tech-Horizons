// Nav background
const header = document.querySelector("header")

window.addEventListener("scroll", () => {
  header.classList.toggle("shadow", window.scrollY > 0)
})

// Filter
document.addEventListener("DOMContentLoaded", () => {
  const filterItems = document.querySelectorAll(".filter-item")
  const postBoxes = document.querySelectorAll(".post-box")

  filterItems.forEach((item) => {
    item.addEventListener("click", function () {
      const value = this.getAttribute("data-filter")

      postBoxes.forEach((box) => {
        if (value === "all" || box.classList.contains(value)) {
          box.style.display = "block"
          setTimeout(() => {
            box.style.opacity = "1"
          }, 0)
        } else {
          box.style.opacity = "0"
          setTimeout(() => {
            box.style.display = "none"
          }, 500)
        }
      })

      // Update active filter
      filterItems.forEach((filterItem) => {
        filterItem.classList.remove("active-filter")
      })
      this.classList.add("active-filter")
    })
  })
})

document.getElementById('numero-filter').addEventListener('change', function() {
  const selectedNumeroId = this.value;
  const url = new URL(window.location.href);
  url.searchParams.set('id_numero', selectedNumeroId);
  window.location.href = url.toString();
});

// Theme toggle
function toggleTheme() {
  const darkTheme = document.getElementById("dark-theme")
  darkTheme.disabled = !darkTheme.disabled

  const button = document.querySelector(".theme-toggle")
  button.classList.toggle("light-mode")
  button.textContent = button.classList.contains("light-mode") ? "Light Mode" : "Dark Mode"
}


