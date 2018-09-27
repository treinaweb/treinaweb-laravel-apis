var baseUrl = "http://escola.test/api";

$(document).ready(function() {
  list();

  $('#list-body').on('click', '.delete-button', function(){
    destroy($(this).attr("data-id"))
  })

  $('#create-button').click(function() {
    $('#register-div').css('display', 'block');
  })

  $('#register-form').submit(function(event) {
    event.preventDefault();
    create();
  });

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

function destroy(id) {
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

function create(){
  $.ajax({
    type: "POST",
    url: `${baseUrl}/students`,
    contentType: "application/json",
    dataType: 'json',
    data: getStudentJsonFromForm(), 
    success: function(students) {
      alert('O aluno foi criado com sucesso!');

      clearHideForm();
      list();
    }
  });
}

function clearHideForm() {
  $('#name').val('');
  $('#birth').val('');
  $('#classroom').val('');
  $('#gender').val($('#gender option:first').val());
  $('#register-div').css('display', 'none');
}

function getStudentJsonFromForm() {
  return JSON.stringify({
    "name": $('#name').val(),
    "birth": $('#birth').val(),
    "classroom_id": $('#classroom').val(),
    "gerder": $('#gender').find('option:selected').val(),
  });
}