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
  });
}

function getColumns() {
  return [
    { data: "id" },
    { data: "name" },
    { render: renderEmailColumn },
    { data: "code" },
    { data: "head" },
    { data: "created" },
    { data: "phone" },
    {
      data: "till_date",
      render: function (data, type, row) {
        var currentDate = new Date();
        var tillDate = new Date(row.till_date);
        var day30 = new Date();
        day30.setDate(currentDate.getDate() + 30);

        var text = '';
        if (tillDate >= currentDate) {
          console.log(row.id, tillDate, day30)
          if (tillDate <= day30) {
            text = `<span class="badge badge-soft-warning">${data}</span>`;
          } else {
            text = `<span class="badge badge-soft-success">${data}</span>`;
          }
        } else {
          text = `<span class="badge badge-soft-danger">${data}</span>`;
        }

        return text;
      }
    },
    { render: renderButtonGroupColumn },
    { render: renderSwitchButtonColumn },
  ];
}

function getColumnDefs() {
  return [
    { targets: [2, 6], visible: false },
    { targets: [7], orderable: false },
  ];
}

function renderButtonGroupColumn(data, type, row) {
  const btnGroupHTML = `<div class="btn-group btn-group-sm">
      <a class="btn btn-success" href="edit-branch.php?id=${row.id}">
        <i class="font-size-10 fas fa-user-edit"></i>
      </a>
      <a class="btn btn-info" href="details-branch.php?id=${row.id}">
        <i class="font-size-10 fas fa-eye"></i>
      </a>
      <a class="btn btn-purple" href="branch-students.php?id=${row.id}">
        <i class="font-size-10 fas fa-user"></i>
        <span>( ${row.count} )</span>
      </a>
      <button data-id="${row.id}" class="btn btn-danger ${row.count < 1 ? 'delete' : 'disabled'}">
          <i class="font-size-10 far fa-trash-alt"></i>
      </button>
    </div>`;
  return btnGroupHTML;
}
