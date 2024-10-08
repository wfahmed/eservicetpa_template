const input = document.getElementById('input-tag');
const tagsUl = document.getElementById('tags');
const dropdown = document.getElementById('tags-dropdown');
const tagsData = document.getElementById('tags-data');

let tags = [];
function addTag(tag) {
    if (!isTagAdded(tag)) {
        tags.push(tag); // Add the tag object to the tags array
        updateTags();
        input.value = '';
        dropdown.innerHTML = '';
        dropdown.style.display = 'none';
    }
}

function isTagAdded(tag) {
    return tags.some(t => t.id == tag.id); // Check if the tag is already added
}

function removeTag(tagElement) {
    const tagId = tagElement.getAttribute('data-id');
    tags = tags.filter(tag => tag.id != tagId); // Remove the tag object from the tags array
    tagElement.remove();
    updateTags(); // Update the displayed tags
    updateTagsData(); // Update the hidden field
}

function updateTags() {
    tagsUl.innerHTML = ''; // Clear existing tags
    tags.forEach(tag => {
        const li = document.createElement('li');
        li.textContent = tag.title; // Display tag title
        li.setAttribute('data-id', tag.id);
        li.className = 'tag-item';

        const closeBtn = document.createElement('span');
        closeBtn.textContent = '×';
        closeBtn.className = 'close-btn';
        closeBtn.addEventListener('click', () => removeTag(li));
        li.appendChild(closeBtn);

        tagsUl.appendChild(li);
    });
    updateTagsData();
}

function updateTagsData() {
    tagsData.value = JSON.stringify(tags); // Update the hidden input field with tags data
}
$(document).ready(function() {
    var predefinedTags;
    $.ajax({
        type: 'POST',
        url: '' + base_url + 'project/get_targets_tags',
        data: '',
        cache: false,
        dataType: 'html',
        context: document.body,
        success: function (data) {
            predefinedTags = JSON.parse(data);
        }
    });



//input.addEventListener('input', function () {
    $('#input-tag').on('input', function () {
        const value = this.value.toLowerCase();
        dropdown.innerHTML = '';
        dropdown.style.display = 'none';

        if (value) {
            const filteredTags = predefinedTags.filter(tag => tag.title.toLowerCase().includes(value));
            if (filteredTags.length > 0) {
                dropdown.style.display = 'block';
                filteredTags.forEach(tag => {
                    const li = document.createElement('li');
                    li.textContent = tag.title;
                    li.setAttribute('data-id', tag.id);
                    li.addEventListener('click', () => addTag(tag));
                    dropdown.appendChild(li);
                });
            }
        }
    });



    document.addEventListener('click', function (e) {
        if (!document.querySelector('.tags-input').contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
});
