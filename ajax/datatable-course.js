function initializeDataTable(tableId, action, spacial = null) {
  return $(tableId).DataTable({
    responsive: true,
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    searching: true,
    bJQueryUI: true,
    pageLength: 50,
    order: [0, "desc"],
    columnDefs: getColumnDefs(),
    buttons: getButtons(),
    ajax: getAjaxConfig(action),
    columns: getColumns(),
    drawCallback: setupSwitchButtonCallback,
    // scrollY: 300
  });
}

function getColumns() {
  return [
    { data: "id" },
    { data: "course_name" },
    { data: "total_fee" },
    { data: "course_code" },

    {
      render: function (data, type, row) {
        return `${row.course_duration} ${row.duration_time}`;
      },
    },
    {
      render: function (data, type, row) {
        return formatDate(row.created_at);
      },
    },
    { render: renderButtonGroupColumn },
    { render: renderSwitchButtonColumn },
  ];
}

function getColumnDefs() {
  return [
    { targets: [6], visible: false },
    { targets: [6], orderable: false },
  ];
}

function renderButtonGroupColumn(data, type, row) {
  let btnGroupHTML = `<div class="btn-group btn-group-sm">
          <a class="btn btn-success" href="edit-course.php?id=${row.id}">
              <i class="font-size-10 fas fa-user-edit"></i>
          </a>
          <a class="btn btn-info" href="details-course.php?id=${row.id}">
              <i class="font-size-10 fas fa-eye"></i>
          </a>
          <button class="btn btn-soft-purple">
              <i class="font-size-10 fas fa-book-open"></i>
              <span>( ${row.count} )</span>
          </button>
          <button data-id="${row.id}" class="btn btn-danger ${row.count < 1 ? "delete" : "disabled"
    }">
            <i class="font-size-10 far fa-trash-alt"></i>
        </button>
      </div>`;
  return btnGroupHTML;
}
