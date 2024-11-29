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
                for (const file of mediaFiles) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const mediaElement = document.createElement('img');
                        mediaElement.src = e.target.result;
                        mediaElement.alt = 'Uploaded Media';
                        mediaElement.style.maxWidth = '100%'; 
                        newsItem.appendChild(mediaElement);
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Add Edit and Delete buttons
            const editButton = document.createElement('button');
            editButton.textContent = 'Edit';
            editButton.classList.add('edit-button');
            editButton.addEventListener('click', () => {
                document.getElementById('news-title').value = title;
                document.getElementById('news-content').value = content;
                newsItem.remove();
            });

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.classList.add('delete-button');
            deleteButton.addEventListener('click', () => newsItem.remove());

            newsItem.appendChild(editButton);
            newsItem.appendChild(deleteButton);

            newsContainer.prepend(newsItem);
            document.getElementById('news-form').reset();
        } else {
            alert('Please fill in the title and content fields.');
        }
    });

    // Edit Game Schedule Row
    function handleEdit(row) {
        const cells = row.querySelectorAll('td');
        document.getElementById('edit-round').value = cells[0].innerText;
        document.getElementById('edit-match').value = cells[1].innerText;
        document.getElementById('edit-teams').value = cells[2].innerText;
        document.getElementById('edit-status').value = cells[3].innerText.toLowerCase().replace(' ', '-');
        document.getElementById('edit-modal').style.display = 'block';

        document.getElementById('save-edit').onclick = () => {
            cells[0].innerText = document.getElementById('edit-round').value;
            cells[1].innerText = document.getElementById('edit-match').value;
            cells[2].innerText = document.getElementById('edit-teams').value;
            cells[3].innerText = document.getElementById('edit-status').value.replace('-', ' ').toUpperCase();
            document.getElementById('edit-modal').style.display = 'none';
        };
    }

    // Delete Game Schedule Row
    function handleDelete(row) {
        document.getElementById('delete-modal').style.display = 'block';
        document.getElementById('confirm-delete').onclick = () => {
            row.remove();
            document.getElementById('delete-modal').style.display = 'none';
        };
        document.getElementById('cancel-delete').onclick = () => {
            document.getElementById('delete-modal').style.display = 'none';
        };
    }

    // Attach event listeners for editing and deleting rows
    document.querySelectorAll('.action-buttons button.edit').forEach(button => {
        button.addEventListener('click', () => handleEdit(button.closest('tr')));
    });

    document.querySelectorAll('.action-buttons button.delete').forEach(button => {
        button.addEventListener('click', () => handleDelete(button.closest('tr')));
    });

    // Close modal buttons
    document.getElementById('close-edit-modal').onclick = () => {
        document.getElementById('edit-modal').style.display = 'none';
    };
    document.getElementById('close-delete-modal').onclick = () => {
        document.getElementById('delete-modal').style.display = 'none';
    };
});

