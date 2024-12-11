// Get the search form and results container
const searchForm = document.querySelector('form');
const searchResults = document.querySelector('.search-results'); // Create a new element for results

searchForm.addEventListener('submit', (event) => {
  event.preventDefault();
  const searchQuery = document.querySelector('input[name="search"]').value.toLowerCase();

  // Clear previous results
  searchResults.innerHTML = '';

  // Find matching links
  const links = document.querySelectorAll('a');
  links.forEach(link => {
    const linkText = link.textContent.toLowerCase();
    if (linkText.includes(searchQuery)) {
      const result = document.createElement('li');
      result.innerHTML = `<a href="${link.href}">${link.textContent}</a>`;
      searchResults.appendChild(result);
    }
  });
});