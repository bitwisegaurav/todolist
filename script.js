const addbtn = document.getElementById('addButton');
const deletebtn = document.getElementById('deleteButton');
const updatebtn = document.getElementById('updateButton');
const addbox = document.getElementById('addModal');
const deletebox = document.getElementById('deleteModal');
const updatebox = document.getElementById('updateModal');
const closebtn = document.querySelectorAll('.close');
const addSubmit = document.getElementById('addSubmit');
const deleteSubmit = document.getElementById('deleteSubmit');
const updateSubmit = document.getElementById('updateSubmit');
const tasklist = document.getElementById('taskList');
let index = 1;

addbtn.addEventListener('click', () => {
    addbox.style.display = 'flex';
});

addSubmit.addEventListener('click', () => location.reload());
deleteSubmit.addEventListener('click', () => location.reload());
updateSubmit.addEventListener('click', () => location.reload());

deletebtn.addEventListener('click', () => {
    deletebox.style.display = 'flex';
});

updatebtn.addEventListener('click', () => {
    updatebox.style.display = 'flex';
});

closebtn.forEach((btn) => {
    btn.addEventListener('click', () => {
        addbox.style.display = 'none';
        deletebox.style.display = 'none';
        updatebox.style.display = 'none';
    });
});