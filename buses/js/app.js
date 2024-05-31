$(document).ready(() => {
  list()
})


async function list() {
  const res = await $.ajax({
    url: '../app/bus/all',
    type: 'GET',
    dataType: 'html'
  })
  $("#data_buses").html(res)
}