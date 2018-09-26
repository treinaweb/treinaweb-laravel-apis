var baseUrl = "http://escola.test/api";

$(document).ready(function() {
  list();

  $('#list-body').on('click', '.delete-button', function(){
    excluir($(this).attr("data-id"))
  })

});

function list() {
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
          <td>
            <button class="delete-button" data-id="${student.id}">Excluir</button>
          </td>
        </tr>
        `
      }

      $('#list-body').html(content);
    }
  });
}

function excluir(id) {
  $.ajax({
    type: "DELETE",
    url: `${baseUrl}/students/${id}`,
    contentType: "application/json",
    success: function(students) {
      alert('O aluno foi excluido com sucesso!');

      list();
    }
  });
}