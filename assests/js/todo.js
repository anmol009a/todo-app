// Function to load and display To-Do items
function loadTodoItems() {
    fetch('api/get_todo.php') // Assuming you have a backend script to fetch To-Do items
        .then(response => response.json())
        .then(data => {
            const emptyMessage = document.getElementById('empty-message');
            const todoList = document.getElementById('todo-list');
            todoList.innerHTML = '';

            if (data.length === 0) {
                emptyMessage.style.display = 'block'; // Display the empty message
            } else {
                emptyMessage.style.display = 'none'; // Display the empty message
                data.forEach(item => {
                    const listItem = document.createElement('li');
                    listItem.classList = "my-3"
                    listItem.innerHTML = `
                    <span>${item.description}</span>
                    <span class="float-end">
                    <button class="btn btn-primary btn-sm" onclick="editTodo(${item.item_id})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                    </svg>
                </button>
                <button class="btn btn-danger btn-sm" onclick="deleteTodo(${item.item_id})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                    </svg>
              </button>
              </span>
                `;
                    todoList.appendChild(listItem);
                });
            }
        })
        .catch(error => console.error('Error:', error));
}

// Function to edit a To-Do item
function editTodo(itemId) {
    const newDescription = prompt('Edit the to-do item:', '');
    if (newDescription !== null) {
        fetch('api/edit_todo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: itemId, description: newDescription }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadTodoItems();
                } else {
                    console.error('Edit failed:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

// Function to delete a To-Do item
function deleteTodo(itemId) {
    fetch('api/delete_todo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 'id': itemId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadTodoItems();
            } else {
                console.error('Deletion failed:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Function to add a new to-do item
function addTodoItem(e) {
    let todoDescription = document.getElementById('todoDescription').value;

    // Check if the description is not empty
    if (todoDescription.trim() !== '') {
        // Send the to-do item description to the server (you need to implement the API)
        fetch('api/add_todo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ description: todoDescription })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add the new to-do item to the list on the front end (you need to implement this)
                    // Load To-Do items when the page loads
                    loadTodoItems();
                    // You can also clear the input field and update the to-do list here
                    // Clear the input field
                    document.getElementById('todoDescription').value = '';                   
                } else {
                    alert('Failed to add the to-do item');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
}
// Add an event listener to the form
document.getElementById('addTodoForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission
    addTodoItem(); // Call the addTodoItem function
});

// Load To-Do items when the page loads
loadTodoItems();

