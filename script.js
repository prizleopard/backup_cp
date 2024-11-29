document.addEventListener('DOMContentLoaded', () => {
    // Handle sidebar menu activation
    const allSideMenuLinks = document.querySelectorAll('#sidebar .side-menu.top li a');
    allSideMenuLinks.forEach(link => {
        const li = link.parentElement;
        link.addEventListener('click', () => {
            allSideMenuLinks.forEach(item => item.parentElement.classList.remove('active'));
            li.classList.add('active');
        });
    });

    // Toggle sidebar visibility
    const menuBar = document.querySelector('#content nav .bx.bx-menu');
    const sidebar = document.getElementById('sidebar');
    menuBar.addEventListener('click', () => sidebar.classList.toggle('hide'));

    // Handle search button click for small screens
    const searchButton = document.querySelector('#content nav form .form-input button');
    const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
    const searchForm = document.querySelector('#content nav form');

    searchButton.addEventListener('click', (e) => {
        if (window.innerWidth < 576) {
            e.preventDefault();
            searchForm.classList.toggle('show');
            searchButtonIcon.classList.toggle('bx-search');
            searchButtonIcon.classList.toggle('bx-x');
        }
    });

    // Adjust sidebar and search form visibility on window resize
    const adjustLayout = () => {
        if (window.innerWidth < 768) {
            sidebar.classList.add('hide');
        } else {
            sidebar.classList.remove('hide');
        }

        if (window.innerWidth > 576) {
            searchForm.classList.remove('show');
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
    };

    adjustLayout();
    window.addEventListener('resize', adjustLayout);

    // Toggle dark mode
    const switchMode = document.getElementById('switch-mode');
    switchMode.addEventListener('change', () => {
        document.body.classList.toggle('dark', switchMode.checked);
    });

    // Handle dropdown menu visibility
    const dropdownButton = document.querySelector('.dropdown-btn');
    dropdownButton.addEventListener('click', function () {
        this.nextElementSibling.classList.toggle('show');
    });

    window.addEventListener('click', (event) => {
        if (!event.target.matches('.dropdown-btn')) {
            document.querySelectorAll('.dropdown-content.show').forEach(dropdown => dropdown.classList.remove('show'));
        }
    });

    // Handle news posting
    document.getElementById('post-button').addEventListener('click', () => {
        const title = document.getElementById('news-title').value.trim();
        const content = document.getElementById('news-content').value.trim();
        const mediaFiles = document.getElementById('news-media').files;
        const newsContainer = document.getElementById('news-container');

        if (title && content) {
            const newsItem = document.createElement('div');
            newsItem.classList.add('news-item');

            const titleElement = document.createElement('h3');
            titleElement.textContent = title;
            newsItem.appendChild(titleElement);

            const contentElement = document.createElement('p');
            contentElement.textContent = content;
            newsItem.appendChild(contentElement);

            // Append uploaded media
            if (mediaFiles.length > 0) {
                Array.from(mediaFiles).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const mediaElement = document.createElement('img');
                        mediaElement.src = e.target.result;
                        mediaElement.alt = 'Uploaded Media';
                        mediaElement.style.maxWidth = '100%';
                        newsItem.appendChild(mediaElement);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Prepend the new item to the news container
            newsContainer.prepend(newsItem);

            // Clear input fields
            document.getElementById('news-title').value = '';
            document.getElementById('news-content').value = '';
            document.getElementById('news-media').value = ''; // Clear file input
        } else {
            alert('Please fill in both the title and content.');
        }
    });
});
