// Main application script
document.addEventListener('DOMContentLoaded', function() {
    // Demo login functionality
    const demoLoginBtn = document.getElementById('demo-login');
    if (demoLoginBtn) {
        demoLoginBtn.addEventListener('click', function() {
            window.location.href = 'dashboard.html';
        });
    }
    
    // Add student form handling
    // const addStudentForm = document.getElementById('addStudentForm');
    // if (addStudentForm) {
    //     addStudentForm.addEventListener('submit', function(e) {
    //         e.preventDefault();
    //         // In a real app, you would send this data to a server
    //         alert('Student added successfully!');
    //         hideAddStudentModal();
    //         // Refresh the student list or add the new student to the UI
    //     });
    // }
    
    // Attendance status buttons
    document.querySelectorAll('.btn-present, .btn-absent, .btn-late').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.attendance-item');
            const statusButtons = this.parentElement.querySelectorAll('button');
            
            // Remove active class from all buttons in this group
            statusButtons.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Update attendance status display
            const statusDisplay = item.querySelector('.attendance-status span');
            if (statusDisplay) {
                statusDisplay.textContent = 'Status: ' + this.textContent;
            }
            
            // Update item border color based on status
            item.classList.remove('present', 'absent', 'late');
            if (this.classList.contains('btn-present')) {
                item.classList.add('present');
            } else if (this.classList.contains('btn-absent')) {
                item.classList.add('absent');
            } else if (this.classList.contains('btn-late')) {
                item.classList.add('late');
            }
        });
    });
    
    // Delete student buttons
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this student?')) {
                this.closest('.student-card').remove();
                // In a real app, you would also send a request to delete from the server
            }
        });
    });
});

// Modal functions
function showAddStudentModal() {
    document.getElementById('addStudentModal').style.display = 'flex';
}

function hideAddStudentModal() {
    document.getElementById('addStudentModal').style.display = 'none';
}

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('addStudentModal');
    if (event.target === modal) {
        hideAddStudentModal();
    }
});