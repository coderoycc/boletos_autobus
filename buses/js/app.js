$(document).ready(() => {
  list()
})

/** EVENTS start **/
$(document).on('change', '#distro_type', show_distro_card)
$(document).on('click', '#btn__new_distro', show_card_new_distro)
/** EVENTS end **/

async function list() {
  const res = await $.ajax({
    url: '../app/bus/all',
    type: 'GET',
    dataType: 'html'
  })
  $("#data_buses").html(res)
}
async function add_new(){
  const res = await $.ajax({
    url: '../app/bus/card_add_new',
    type: 'GET',
    dataType: 'html'
  });
  $("#data_buses").html(`
    <div class="col-md-5" id="col__data"></div>
    <div class="col-md-7" id="col__details"></div>`
  );
  $("#col__data").html(res)
}
async function show_distro_card(e){
  const id = e.target.value;
  if(id == '') return;
  const res = await $.ajax({
    url: '../app/distribution/card_distro_seats',
    type: 'GET',
    data: { id },
    dataType: 'html'
  });
  $("#col__details").html(res)
}
async function show_card_new_distro(e){
  
}