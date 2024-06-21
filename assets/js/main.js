function sortByName() {
    const nameIcon = document.getElementById('sortNameIcon');
    const diffIcon = document.getElementById('sortDiffIcon');
    const courseTable = document.getElementById('course-table');
    const children = courseTable.querySelectorAll('div');
    const grandChildren = children[3].querySelectorAll('p');
    
    if (grandChildren[1].textContent === 'Scripting and Programming - Applications') {
        nameIcon.classList.remove('logo');
        diffIcon.classList.remove('logo');
        nameIcon.src = 'assets/images/sort-alpha-down.svg';
        diffIcon.src= 'assets/images/sort-numeric-down.svg';
    }
    else if (grandChildren[1].textContent === 'Advanced Java') {
        nameIcon.classList.add('logo');
        diffIcon.classList.remove('logo');
        nameIcon.src= 'assets/images/sort-alpha-down.svg';
        diffIcon.src= 'assets/images/sort-numeric-down.svg';
    }
    else if (grandChildren[1].textContent === 'Version Control') {
        diffIcon.classList.remove('logo');
        nameIcon.classList.add('logo');
        nameIcon.src = 'assets/images/sort-alpha-up.svg';
        diffIcon.src= 'assets/images/sort-numeric-down.svg';
    }
    else if (grandChildren[1].textContent === 'Scripting and Programming - Foundations') {
        nameIcon.classList.remove('logo');
        diffIcon.classList.add('logo');
        nameIcon.src = 'assets/images/sort-alpha-down.svg';
        diffIcon.src= 'assets/images/sort-numeric-down.svg';
    }
    else if (grandChildren[1].textContent === 'Discrete Mathematics II') {
        nameIcon.classList.remove('logo');
        diffIcon.classList.add('logo');
        nameIcon.src = 'assets/images/sort-alpha-down.svg';
        diffIcon.src= 'assets/images/sort-numeric-up.svg'
    }
}

function addCourseLinks() {
    const courseContainers = document.getElementsByClassName('course-container');

    for (let i = 0; i < courseContainers.length; i++) {
        courseContainers[i].addEventListener('click', () => {
            const courseId = courseContainers[i].querySelector('.course-number-field').innerHTML;
            submitFormWithData(courseId);
        });
    }
}

function submitFormWithData(courseId) {
    const form = document.getElementById('form');
    form.querySelector('input').value = `${courseId}`;
    form.submit();
}

if (window.location.href.includes('/the-owl-roost/')) {
    sortByName();
    addCourseLinks();
}