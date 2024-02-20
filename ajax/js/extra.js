$("#profile_image").on("change", function () {
  if (this.files && this.files[0]) {
    var reader = new FileReader();
    reader.onload = (e) =>
      $("#imagePreview").attr("src", e.target.result).show();
    reader.readAsDataURL(this.files[0]);
  }
});

$(".password-eye").on("click", function () {
  var passwordInput = $(this).siblings("input");
  var isPassword = passwordInput.attr("type") === "password";
  passwordInput.attr("type", isPassword ? "text" : "password");
  $(this).find("i").toggleClass("fa-eye fa-eye-slash");
});

$("#search").on("keyup", function () {
  var value = $(this).val().toLowerCase();
  $("tbody tr").filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
  });
});

function alertifySuccess(message, mail = null) {
  alertify.success(message + " : " + mail);
}



function initializeCustomSelect2(selector, classes) {
  $(selector).select2({
    width: "auto",
    minimumResultsForSearch: -1,
    templateSelection: function (data) {
      if (!data.id) {
        return data.text;
      }
      var colorClass = classes[data.id] || "text-default";
      return $(
        '<span class="btn btn-sm ' + colorClass + '">' + data.text + "</span>"
      );
    },
  });
}

function deleteItem(table, itemType, deleteText, successText) {
  $(document).on("click", ".delete", function () {
    var itemId = $(this).data("id");
    const trId = $(this).closest("tr");
    Swal.fire({
      title: "Are you sure?",
      text: deleteText,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#51d28c",
      cancelButtonColor: "#f34e4e",
      confirmButtonText: "Yes, delete it!",
    }).then(function (result) {
      if (result.isConfirmed) {
        const data = {
          itemId: itemId,
          action: itemType,
        };
        const url = "../php/controller/commonController.php";
        const success = function (response) {
          console.log(response)
          if (!response.status) {
            alert("Failed to Delete " + itemType);
          }
          table.row(trId).remove().draw();
        };
        performAjaxRequest(url, data, success);
      }
      if (result.value) {
        Swal.fire(itemType + " Deleted!", successText, "success");
      }
    });
  });
}

function copyToClipboard(text) {
  navigator.clipboard
    .writeText(text)
    .then(() => alertifySuccess("copy", text))
    .catch(() => console.error("Copy failed"));
}

function getAjaxConfig(action) {
  return {
    url: "../php/controller/datatableController.php",
    type: "POST",
    data: action,
    dataSrc: function (response) {
      console.log(response);
      return response.data;
    },
  };
}

function getButtons() {
  return [
    {
      extend: "excel",
      text: "Excel Export",
      className: "btn btn-sm btn-primary",
    },
    {
      extend: "copyHtml5",
      text: "Copy to Excel",
      exportOptions: {
        columns: [0, ":visible"],
      },
      className: "btn btn-sm btn-info",
    },
    {
      extend: "colvis",
      text: "Column visibility",
      className: "btn btn-sm btn-success",
    },
  ];
}

function renderEmailColumn(data, type, row) {
  return `<code  onclick="copyToClipboard('${row.email}')" class="text-dark">${row.email}</code>`;
}

function renderEnrollmentColumn(data, type, row) {
  return `<div id=row${row.id}>${row.enrollment}</div>`;
}

function renderDateAdmissionColumn(data, type, row) {
  return formatDate(row.date_admission);
}

function renderApprovalColumn(data, type, row) {
  return `<button class="text-uppercase badge fs-6 border-0 bg-${
    row.approve === "yes" ? "success" : "danger"
  } approve" data-id="${row.id}" ${row.approve === "yes" ? "disabled" : ""}>
    <i class="bx bx-${row.approve === "yes" ? "badge-check" : "x"}"></i>
  </button>`;
}

function renderStudentStatusColumn(data, type, row) {
  return `<select class="form-select form-select-sm student_status select2 dropdown-toggle" data-id="${
    row.id
  }">
    <option value="complete" ${
      row.student_status === "complete" ? "selected disabled" : ""
    }>Completed</option>
    <option value="running" ${
      row.student_status === "running" ? "selected disabled" : ""
    }>Running</option>
    <option value="dropout" ${
      row.student_status === "dropout" ? "selected disabled" : ""
    }>Drop Out</option>
  </select>`;
}

function renderExpiryDateColumn(data, type, row) {
  return `<div class="btn btn-sm btn-danger">${formatDate(
    row.expiry_date
  )}</div>`;
}



function setupSwitchButtonCallback(settings) {
  $(".switch_button").change(function () {
    const itemId = $(this).data("id");
    const data = {
      itemId: itemId,
      action: "statusUpdate",
    };
    const success = function (response) {
      console.log(response);
      if (response.status !== "success") {
        alert(response.message);
      }
    };
    const url = "../php/controller/branchController.php";
    performAjaxRequest(url, data, success);
  });
}

function renderSwitchButtonColumn(data, type, row) {
  const btnGroupHTML = `<div class="form-check form-switch">
    <input type="checkbox" class="form-check-input switch_button" data-id='${
      row.id
    }' id="switch${row.id}" ${row.status === "active" ? "checked" : ""}>
    <label class="form-check-label" for="switch${row.id}"></label>
  </div>`;
  return btnGroupHTML;
}
