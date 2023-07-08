/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

const base_url = 'http://localhost:8080/'

function showAlert(icon, title, text) {
    Swal.fire({
        icon: icon,
        title: title,
        text: text
    });
}

function signOut() {
    Swal.fire({
        title: 'Logout',
        text: 'Are you sure you want to logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `${base_url}dashboard/logout`,
                type: 'GET',
                dataType: 'JSON',
                success: function (response) {
                    if (response.success) {
                        showAlert(response.icon, response.title, response.message);
                        window.location.href = `${base_url}`;
                    } else {
                        showAlert(response.icon, response.title, response.message);
                    }
                },
                error: function () {
                    alert('An error occurred while processing your request.');
                }
            });
        }
      });
}