/**
 * Populate the update user modal with user data
 * @param {Object} user - User data object
 */
function populateUpdateModal(user) {
  document.getElementById('update_user_id').value = user.id;
  document.getElementById('update_full_name').value = user.full_name;
  document.getElementById('update_email').value = user.email;
  document.getElementById('update_role').value = user.role;
  document.getElementById('update_department').value = user.department;
  document.getElementById('update_vacation_leave').value = user.vacation_leave;
  document.getElementById('update_sick_leave').value = user.sick_leave;
}

/**
 * Populate the delete user modal with user id
 * @param {Number} userId - User ID to delete
 */
function populateDeleteModal(userId) {
  document.getElementById('delete_user_id').value = userId;
}