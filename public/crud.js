var baseUrl = "http://escola.test/api";

$(document).ready(function() {
  list();

  $('#list-body').on('click', '.delete-button', function(){
    destroy($(this).attr("data-id"))
  })

  $('#list-body').on('click', '.update-button', function(){
    mountFormForUpdate($(this).attr("data-id"))
  })

  $('#create-button').click(function() {
    formShow();
  })

  $('#register-form').submit(function(event) {
    event.preventDefault();

    let id = $('#id').val();
    if (id == "") {
      create();
    } else {
      update(id);
    }
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
            <button class="update-button" data-id="${student.id}">Atualizar</button>
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
    success: function() {
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
    success: function() {
      alert('O aluno foi criado com sucesso!');

      clearHideForm();
      list();
    },
    error: function(error) {
      showValidationErros(error);
    }
  });
}

function update(id) {
  $.ajax({
    type: "PUT",
    url: `${baseUrl}/students/${id}`,
    contentType: "application/json",
    dataType: 'json',
    data: getStudentJsonFromForm(), 
    success: function() {
      alert('O aluno foi atualizado com sucesso!');

      clearHideForm();
      list();
    },
    error: function(error) {
      showValidationErros(error);
    }
  });
}

function mountFormForUpdate(id) {
  $.ajax({
    type: "GET",
    url: `${baseUrl}/students/${id}`,
    headers: {
      "Accept": "application/json"
    },
    contentType: "application/json",
    success: function(student) {
      $("#id").val(student.data.id);
      $("#name").val(student.data.name);
      $("#birth").val(student.data.birth);
      $("#classroom").val(student.data.classroom.id);
      $("#gender").val(student.data.gender);
    }
  });
  
  formShow();
}

function clearHideForm() {
  $('#id').val('');
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

function formShow() {
  $('#register-div').css('display', 'block');
}

function showValidationErros(error){
  if (error.status == 422) {
    let errors = error.responseJSON;
    for (const key in errors) {
      alert(`${key}: ${errors[key]}`)
    }
  } else {
    alert(error.responseText)
  }
}