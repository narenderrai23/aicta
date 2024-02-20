function fetchChoices(
  formData,
  elementSelector,
  labelKey,
  controllerUrl,
  selected = null
) {
  new Choices(elementSelector).setChoices((callback) => {
    return fetch("../php/controller/" + controllerUrl, {
      body: formData,
      method: "post",
    })
      .then((res) => res.json())
      .then((response) => {
        return response.map((release) => ({
          label: String(release[labelKey]),
          value: release["id"],
          selected: selected !== null && release["id"] == selected,
        }));
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
}

function fetchStates(selected = null) {
  let formData = new FormData();
  formData.append("action", "fetchState");
  fetchChoices(
    formData,
    "#state",
    "state_name",
    "stateController.php",
    selected
  );
}

function fetchlevel(selected = null) {
  let formData = new FormData();
  formData.append("action", "fetchlevel");
  fetchChoices(formData, "#level", "level", "stateController.php", selected);
}

function fetchCourse(selected = null) {
  let formData = new FormData();
  formData.append("action", "SelectCourse");
  fetchChoices(
    formData,
    "#course",
    "course_code",
    "commonController.php",
    selected
  );
}

function fetchBranches(selected = null) {
  let formData = new FormData();
  formData.append("action", "fetchAllBranch");
  fetchChoices(formData, "#branch", "name", "branchController.php", selected);
}

function fetchCategory(selected = null) {
  let formData = new FormData();
  formData.append("action", "SelectCategory");
  fetchChoices(
    formData,
    "#ccat",
    "name",
    "commonController.php",
    selected
  );
}

function fetchCity(stateId, selected = null) {
  if (stateId) {
    $.post(
      "../php/controller/cityController.php",
      {
        action: "fetchCity",
        state_id: stateId,
      },
      function (response) {
        SelectOption(response, $("#city"), "city_name");
        $("#city").val(selected);
      },
      "json"
    );
  }
}

function fetchDistrict(state, selected = null) {
  if (state) {
    $.post(
      "../php/controller/cityController.php",
      {
        action: "fetchDistrict",
        state_id: state,
      },
      function (response) {
        SelectOption(response, $("#district"), "district");
        $("#district").val(selected);
      },
      "json"
    );
  }
}

function SelectOption(response, select_dropdown, selectedCityName) {
  select_dropdown.empty().append($("<option>").text("Select").val(""));
  $.each(response, function (key, value) {
    select_dropdown.append(
      $("<option>").text(value[selectedCityName]).val(value.id)
    );
  });
}



function fetchCourseCode(id) {
  if (id) {
    $.post(
      "../php/controller/commonController.php",
      {
        action: "getCourseName",
        id: id,
      },
      function (response) {
        $("#course_code").val(response.course_name);
        $("#cduration").val(`${response.course_duration} ${response.duration_time}`);
        $("#total_fee").val(response.total_fee);
        $("#course_type").val(response.course_type);
        $("#eligibility").val(response.eligibility);
      },
      "json"
    );
  }
}

function fetchBranchCode(id) {
  if (id) {
    $.post(
      "../php/controller/branchController.php",
      {
        action: "SelectBranchCode",
        state_id: id,
      },
      function (response) {
        $("#code").val(response.code);
      },
      "json"
    );
  }
}

function performAjaxRequest(url, data, success) {
  $.ajax({
    url: url,
    method: "POST",
    data: data,
    dataType: "json",
    success: success,
    error: function (xhr, status, error) {
      console.error("Error occurred during the operation:", xhr.responseText);
    },
  });
}

function ajax(url, formData, success) {
  $.ajax({
    url: url,
    type: "POST",
    data: formData,
    dataType: "json",
    processData: false,
    contentType: false,
    success: success,
    error: function (xhr, status, err) {
      console.error("Error occurred during the operation:", xhr.responseText);
    },
  });
}

function formatDate(inputDate) {
  const options = {
    year: "numeric",
    month: "short",
    day: "numeric",
  };
  const date = new Date(inputDate);
  return date.toLocaleDateString("en-US", options);
}
