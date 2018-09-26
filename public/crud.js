var baseUrl = "http://escola.test/api";

$(document).ready(function() {
  $.ajax({
    type: "GET",
    url: `${baseUrl}/students`,
    contentType: "application/json",
    success: function(students) {
      let content = '';

      for (const student of students.data) {
        content += `
        <tr>
          <td>${student.id}</td>
          <td>${student.name}</td>
          <td>${student.birth}</td>
          <td>${student.gender}</td>
        </tr>
        `
      }

      $('#list-body').html(content);

    }
  });
});