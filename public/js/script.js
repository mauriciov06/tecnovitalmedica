$(function() {
    $('.btn').tooltip();
});

$( document ).ready(function() {
    
    $('.buscarporfecha').click(function(){
	    var token = $('#token').val();
	    var idInstitucion = $(this).data('idinstitucion');
	    var idEquipo = $(this).data('idequipo');
	    var tipoArchivo = $(this).data('tipoarchivo');
	    
	    var selectorData = '';
	    if(tipoArchivo == 2){
	        selectorData = $('#mantenimientoP .listado-de-archivos');
	        var fechaInicio = $('#mantenimientoP .fecha_inicio').val();
	        var fechaFinal = $('#mantenimientoP .fecha_final').val();
	        var tipoCareta = '/Mantenimiento Preventivo/';
	    }else if(tipoArchivo == 3){
	        selectorData = $('#mantenimientoC .listado-de-archivos');
	        var fechaInicio = $('#mantenimientoC .fecha_inicio').val();
	        var fechaFinal = $('#mantenimientoC .fecha_final').val();
	        var tipoCareta = '/Mantenimiento Correctivo/';
	    }else if(tipoArchivo == 4){
	        selectorData = $('#calibraciones .listado-de-archivos');
	        var fechaInicio = $('#calibraciones .fecha_inicio').val();
	        var fechaFinal = $('#calibraciones .fecha_final').val();
	        var tipoCareta = '/Calibraciones/';
	    }
	    
	    var nombrecarpeta = $(this).data('nombrecarpeta');
	    var validate = false;
	    var msj_error = '';
	    var route = '/busquedaarchivos/';
	    
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data:{idInstitucion:idInstitucion, idEquipo:idEquipo, tipoArchivo:tipoArchivo,fechaInicio:fechaInicio,fechaFinal:fechaFinal},
            beforeSend:function(){
                selectorData.html('');
                selectorData.prepend('<i class="fas fa-spinner fa-spin"></i>');
            },
            success:function(response){
                selectorData.html('');
                
                if(response.data != 0){
                    $.each( response.data, function( i, val ) {
                        selectorData.append(
                            '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="documento-'+val.id+'">'+
                                '<div class="input-group">'+
                                    '<label>'+val.nombre_archivo+'</label>'+
                                    '<a href="/listado_instituciones/'+nombrecarpeta+tipoCareta+val.nombre_archivo+'" target="_blank" class="btn ver-archivo">Ver Archivo</a>'+
                                    '<a class="btn-eliminar" data-idinstitucion="'+val.id_instituciones+'" data-data-idequipo="'+val.id_equipo_medico+'" data-idarchivo="'+val.id+'" data-nombrecarpeta="'+nombrecarpeta+'" data-tipoarchivo="'+tipoArchivo+'" id="'+val.id+'" data-target="#modalEliminarArchivo" data-toggle="modal">'+
        				                '<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>'+
        				            '</a>'+
                                '</div>'+
                            '</div>'
                        );
                    });
                }else{
                    selectorData.append("<div style='margin:0 15px 18px;' class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>Upps!</strong> No se encontrarón registros para las fechas seleccionadas.</div>");
                }
                
            }
        });
        
	});
    
    
    
    
    $('#modalEliminarArchivo').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        
        var idarchivo = button.data('idarchivo');
        var idInstitucion = button.data('idinstitucion');
        var idEquipo = button.data('idequipo');
        var tipoArchivo = button.data('tipoarchivo');
        var nombrecarpeta = button.data('nombrecarpeta');
        
        var modal = $(this)
        modal.find('.modal-footer .btn-eliminarDocumento').attr('data-idarchivo',idarchivo);
        modal.find('.modal-footer .btn-eliminarDocumento').attr('data-idinstitucion',idInstitucion);
        modal.find('.modal-footer .btn-eliminarDocumento').attr('data-idequipo', idEquipo);
        modal.find('.modal-footer .btn-eliminarDocumento').attr('data-tipoarchivo', tipoArchivo);
        modal.find('.modal-footer .btn-eliminarDocumento').attr('data-nombrecarpeta', nombrecarpeta);
        
	});
    
    $('#fileManager').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        
        var idInstitucion = button.data('idinstitucion');
        var idEquipo = button.data('idequipo');
        var tipoArchivo = button.data('archivo');
        
        var modal = $(this)
        modal.find('.modal-body #id_institu').val(idInstitucion);
        modal.find('.modal-body #id_equipo').val(idEquipo);
        modal.find('.modal-body #tipo_archivo').val(tipoArchivo);
        
	});
    
    $('.content-section-modulo select').select2();
    $('.modal select').select2();
    
    $('#modalEditarCiudad').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-footer .btn-crear-ciudad').attr('data-idciu', id)
        var route = '/ciudades/'+id+'/edit';
    	$.get(route, function(res){
    		$('#nombre_ciudad_edit').val(res.nombre_ciudad);
    	});
	});
	
	$('#editar-ciudad-confi').click(function(){
	    var token = $('#token').val();
	    var id = $(this).data('idciu');
	    var nombre_ciudad = $('#nombre_ciudad_edit').val();
	    var validate = false;
	    var msj_error = '';
	    var route = '/ciudades/'+id;
	    
	    if(nombre_ciudad != ''){
	        $.ajax({
              url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'put',
              dataType: 'json',
              data:{id:id,nombre_ciudad:nombre_ciudad},
              beforeSend:function(){
              	msj_successs = 'Estamos procesando los datos, por favor espere un momento.';
                $("#mensaje-request-ciu-edi").html("<div style='margin:0 15px;' class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_successs +"</div>");
              },
              success:function(){
                msj_successs = 'Se ha editado la ciudad satisfactoriamente';
                $("#mensaje-request-ciu-edi").html("<div style='margin:0 15px;' class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_successs +"</div>");
              	setTimeout('document.location.reload()', 2000);
              }
            });
	    }else{
	        validate = true;
            msj_error = 'Por favor ingrese el nombre de la ciudad';
	    }
	    
	    if(validate){
          $('#mensaje-request-ciu-edi').fadeIn();
          $("#mensaje-request-ciu-edi").html("<div style='margin:0 15px;' class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_error +"</div>");
        }
	});

	$('#modalEliminar').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget)
	  var id = button.data('id')
	  var modal = $(this)
	  modal.find('.modal-footer .btn-eliminarConfi').attr('data-id', id)
	})

	$("#selec_tipo_archivo").change(function(event){
		var tipo_archivo = $("#selec_tipo_archivo").val();
		if(tipo_archivo == 6){
			$("#equipo-none").hide("slow");
			$("#select_equipo").empty();
			$("#select_equipo").prepend("<option value='0' selected>Seleccionar equipo</option>");
		}else{
			$("#equipo-none").show("slow");
			var id_institucion = $("#select_insti").val();
			$.get("equipos/"+id_institucion+"", function(response, inst){
				$("#select_equipo").empty();
					for(i=0; i<response.length; i++){
						$("#select_equipo").append("<option value='"+response[i].id+"'>"+response[i].nombre_equipo_medico+"</option>");
					}
			});
		}
	});


	$("#select_insti").click(function(e){
		$.get("equipos/"+event.target.value+"", function(response, inst){
			$("#select_equipo").empty();
				for(i=0; i<response.length; i++){
					$("#select_equipo").append("<option value='"+response[i].id+"'>"+response[i].nombre_equipo_medico+"</option>");
				}
		});
	});
	$("#select_insti").change(function(event){
		$.get("equipos/"+event.target.value+"", function(response, inst){
			$("#select_equipo").empty();
				for(i=0; i<response.length; i++){
					$("#select_equipo").append("<option value='"+response[i].id+"'>"+response[i].nombre_equipo_medico+"</option>");
				}
		});
	});
	
	$("#tipo_cuenta").change(function(event){
	    if(event.target.value == 3){
	        $(".select_institucion").show();
	    }else{
	        $(".select_institucion").hide();
	        $('#id__user_institucion').val('').trigger("change.select2");
	    }
	});
	
	


	$('.sidebar #accordion .panel-heading .panel-title a').click(function(e){
		$( ".sidebar #accordion .panel-heading .panel-title a" ).each(function() {
		  $( this ).removeClass( "active" );
		});
		$( this ).addClass( "active" );
	});

	$('.crear_contacto').click(function(e){
		var id_institucion = $(this).data('idinstitucion');
		$('#id_institucion').val(id_institucion);
	});
	
	$('.btn-eliminarDocumento').click(function(){
		var idarchivo = $(this).attr('data-idarchivo');
        var idInstitucion = $(this).attr('data-idinstitucion');
        var idEquipo = $(this).attr('data-idequipo');
        var tipoArchivo = $(this).attr('data-tipoarchivo');
        var nombrecarpeta = $(this).attr('data-nombrecarpeta');
        console.log(idarchivo);
        console.log(idInstitucion);
        console.log(idEquipo);
        console.log(tipoArchivo);
        console.log(nombrecarpeta);
        var chapchat_pass = $('#chapchat-pass-doc').val();
        var token = $('#token').val();
		var validate = false;
    	var msj_error = '';
        
		var route = '/eliminardocumento';
		
		if(chapchat_pass == '12345'){
			$.ajax({
              url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'POST',
              data:{idarchivo:idarchivo, tipoArchivo:tipoArchivo ,nombrecarpeta:nombrecarpeta},
              beforeSend:function(){
                $('#msg-eliminar-modal-arch').html("<div style='margin:12px 0 0;' class='alert alert-info alert-dismissible' role='alert'> Estamos procesando los datos, por favor espere un momento. </div>");
              	$('#msg-eliminar-modal-arch').fadeIn(1000);
              	$('.btn-eliminarDocumento').attr('disabled',true);
              },
              success:function(response){
              	if(response.estado == true){
	                $('#msg-eliminar-modal-arch').html("<div style='margin:12px 0 0;' class='alert alert-success alert-dismissible' role='alert'> "+ response.mensaje +"</div>");
	                $('#msg-eliminar-modal-arch').fadeIn(800);
	              	setTimeout('document.location.reload()', 2000);
              	}else{
              		$('#msg-eliminar-modal-arch').html("<div style='margin:12px 0 0;' class='alert alert-danger alert-dismissible' role='alert'> "+ response.mensaje +"</div>");
              		$('#msg-eliminar-modal-arch').fadeIn(1000);
              	}
              }
            })
		}else{
			validate = true;
      		msj_error = 'Por favor ingrese los digitos para confirmar.';
		}
		if(validate){
			$("#msg-eliminar-modal-arch").html("<div style='margin:12px 0 0;' class='alert alert-danger alert-dismissible' role='alert'>"+ msj_error +"</div>");
	      	$('#msg-eliminar-modal-arch').fadeIn(1000);
	    }
	});

	$('.btn-eliminarConfi').click(function(){
		var ruta = location.pathname;
		var chapchat_pass = $('#chapchat-pass').val();
		var id = $(this).attr('data-id');
		var token = $('#token').val();
		var validate = false;
    	var msj_error = '';
        
		if(chapchat_pass == '12345'){
			$.ajax({
              url: ruta+'/'+id,
              headers: {'X-CSRF-TOKEN': token},
              type: 'DELETE',
              data:{id:id},
              beforeSend:function(){
                $('#msg-eliminar-modal').html("<div style='margin:12px 0 0;' class='alert alert-info alert-dismissible' role='alert'> Estamos procesando los datos, por favor espere un momento. </div>");
              	$('#msg-eliminar-modal').fadeIn(1000);
              	$('.btn-eliminarConfi').attr('disabled',true);
              },
              success:function(response){
              	if(response.borrado == true){
	                $('#msg-eliminar-modal').html("<div style='margin:12px 0 0;' class='alert alert-success alert-dismissible' role='alert'> "+ response.mensaje +"</div>");
	                $('#msg-eliminar-modal').fadeIn(800);
	              	setTimeout('document.location.reload()', 2000);
              	}else{
              		$('#msg-eliminar-modal').html("<div style='margin:12px 0 0;' class='alert alert-danger alert-dismissible' role='alert'> Upps! ha fallado la eliminación.</div>");
              		$('#msg-eliminar-modal').fadeIn(1000);
              	}
              }
            })
		}else{
			validate = true;
      		msj_error = 'Por favor ingrese los digitos para confirmar.';
		}
		if(validate){
			$("#msg-eliminar-modal").html("<div style='margin:12px 0 0;' class='alert alert-danger alert-dismissible' role='alert'>"+ msj_error +"</div>");
	      	$('#msg-eliminar-modal').fadeIn(1000);
	    }
	});
	
	$('#crear-ciudad-confi').click(function(){
	    var token = $('#token').val();
	    var nombre_ciudad = $('#nombre_ciudad').val();
	    var validate = false;
	    var msj_error = '';
	    var route = '/ciudades';
	    
	    if(nombre_ciudad != ''){
	        $.ajax({
              url: route,
              headers: {'X-CSRF-TOKEN': token},
              type: 'post',
              dataType: 'json',
              data:{nombre_ciudad:nombre_ciudad},
              beforeSend:function(){
              	msj_successs = 'Estamos procesando los datos, por favor espere un momento.';
                $("#mensaje-request-ciu").html("<div style='margin:0 15px;' class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_successs +"</div>");
              },
              success:function(){
                msj_successs = 'Se ha creado la ciudad satisfactoriamente';
                $("#mensaje-request-ciu").html("<div style='margin:0 15px;' class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_successs +"</div>");
              	setTimeout('document.location.reload()', 2000);
              }
            });
	    }else{
	        validate = true;
            msj_error = 'Por favor ingrese el nombre de la ciudad';
	    }
	    
	    if(validate){
          $('#mensaje-request-ciu').fadeIn();
          $("#mensaje-request-ciu").html("<div style='margin:0 15px;' class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_error +"</div>");
        }
	});

	$('#crear-contacto').click(function(e){
		var token = $('#token').val();
		var nombre_contacto = $('#name_contacto').val();
		var email_contacto = $('#email_contacto').val();
		var telefono_contacto = $('#telefono_contacto').val();
		var ciudad_contacto = $('#id_ciudad_contacto').val();
		var celular_contacto = $('#celular_contacto').val();
		var password_contacto = $('#password_contacto').val();
		var id_institucion = $('#id_institucion').val();
		var validate = false;
    var msj_error = '';
    var route = '/usuarios-contacto';

		if(nombre_contacto != ''){
			if(email_contacto != ''){
				if(email_contacto.match(/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/)){
					if(telefono_contacto != ''){
						if(telefono_contacto.match(/^[0-9\s]+$/)){
							if(ciudad_contacto != 'any'){
								if(celular_contacto != ''){
									if(celular_contacto.match(/^[0-9\s]+$/)){
										if(password_contacto != ''){
											$.ajax({
	                      url: route,
	                      headers: {'X-CSRF-TOKEN': token},
	                      type: 'post',
	                      dataType: 'json',
	                      data:{nombre_contacto:nombre_contacto,email_contacto:email_contacto,telefono_contacto:telefono_contacto,ciudad_contacto:ciudad_contacto,
	                            celular_contacto:celular_contacto,password_contacto:password_contacto,id_institucion:id_institucion},
	                      beforeSend:function(){
	                      	msj_successs = 'Estamos procesando los datos, por favor espere un momento.';
	                        $("#mensaje-request").html("<div style='margin:0 15px;' class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_successs +"</div>");
	                      },
	                      success:function(){
	                        msj_successs = 'Se ha creado el contacto satisfactoriamente';
	                        $("#mensaje-request").html("<div style='margin:0 15px;' class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_successs +"</div>");
	                      	setTimeout('document.location.reload()', 2000);
	                      }
	                    })
										}else{
											validate = true;
      								msj_error = 'Por favor ingrese la contraseña';
										}
									}else{
										validate = true;
      							msj_error = 'El celular solo debe contener caracteres numéricos';
									}
								}else{
									validate = true;
      						msj_error = 'Por favor ingrese el celular del contacto';
								}
							}else{
								validate = true;
      					msj_error = 'Por favor seleccione la ciudad del contacto';
							}
						}else{
							validate = true;
      				msj_error = 'El telefono solo debe contener caracteres numéricos';
						}
					}else{
						validate = true;
      			msj_error = 'Por favor ingrese el telefono del contacto';
					}
				}else{
					validate = true;
      		msj_error = 'Por favor ingrese un correo electronico valido';
				}
			}else{
				validate = true;
      	msj_error = 'Por favor ingrese el correo electronico del contacto';
			}
		}else{
			validate = true;
      msj_error = 'Por favor ingrese el nombre del contacto';
		}

		if(validate){
      $('#msj-success').fadeOut();
      $('#mensaje-request').fadeIn();
      $("#mensaje-request").html("<div style='margin:0 15px;' class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_error +"</div>");
    }

	});

	$('.ver_contacto').click(function(e){
		var idusucontacto = $(this).data('idusucontacto');
		$('#id_usucontc_2').val(idusucontacto);
		var route = '/usuarios-contacto/'+idusucontacto+'/edit';
		$.get(route, function(res){
			$('#name_contacto_2').val(res.name);
			$('#telefono_contacto_2').val(res.telefono);
			$('#celular_contacto_2').val(res.celular);
			$('#email_contacto_2').val(res.email);
			$('#id_ciudad_contacto_2').val(res.id_ciudad);
			$('.modal select').val(res.id_ciudad).trigger('change.select2');
		});
	});


	$('#ver-contacto').click(function(e){
		var token = $('#token_2').val();
		var nombre_contacto = $('#name_contacto_2').val();
		var email_contacto = $('#email_contacto_2').val();
		var telefono_contacto = $('#telefono_contacto_2').val();
		var ciudad_contacto = $('#id_ciudad_contacto_2').val();
		var celular_contacto = $('#celular_contacto_2').val();
		var password_contacto = $('#password_contacto_2').val();
		var id_usercon2 = $('#id_usucontc_2').val();
		var validate = false;
    var msj_error = '';
    var route = '/usuarios-contacto/'+id_usercon2;

		if(nombre_contacto != ''){
			if(email_contacto != ''){
				if(email_contacto.match(/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/)){
					if(telefono_contacto != ''){
						if(telefono_contacto.match(/^[0-9\s]+$/)){
							if(ciudad_contacto != 'any'){
								if(celular_contacto != ''){
									if(celular_contacto.match(/^[0-9\s]+$/)){
										$.ajax({
                      url: route,
                      headers: {'X-CSRF-TOKEN': token},
                      type: 'PUT',
                      dataType: 'json',
                      data:{nombre_contacto:nombre_contacto,email_contacto:email_contacto,telefono_contacto:telefono_contacto,ciudad_contacto:ciudad_contacto,
                            celular_contacto:celular_contacto,password_contacto:password_contacto,id_usercon2:id_usercon2},
                      beforeSend:function(){
                      	msj_successs = 'Estamos procesando los datos, por favor espere un momento.';
                        $("#mensaje-request_2").html("<div style='margin:0 15px;' class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_successs +"</div>");
                      },
                      success:function(){
                        msj_successs = 'Se ha actualizado el contacto satisfactoriamente';
                        $("#mensaje-request_2").html("<div style='margin:0 15px;' class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_successs +"</div>");
                      	setTimeout('document.location.reload()', 2000);
                      }
                    })
									}else{
										validate = true;
      							msj_error = 'El celular solo debe contener caracteres numéricos';
									}
								}else{
									validate = true;
      						msj_error = 'Por favor ingrese el celular del contacto';
								}
							}else{
								validate = true;
      					msj_error = 'Por favor seleccione la ciudad del contacto';
							}
						}else{
							validate = true;
      				msj_error = 'El telefono solo debe contener caracteres numéricos';
						}
					}else{
						validate = true;
      			msj_error = 'Por favor ingrese el telefono del contacto';
					}
				}else{
					validate = true;
      		msj_error = 'Por favor ingrese un correo electronico valido';
				}
			}else{
				validate = true;
      	msj_error = 'Por favor ingrese el correo electronico del contacto';
			}
		}else{
			validate = true;
      msj_error = 'Por favor ingrese el nombre del contacto';
		}

		if(validate){
      $('#msj-success').fadeOut();
      $('#mensaje-request_2').fadeIn();
      $("#mensaje-request_2").html("<div style='margin:0 15px;' class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+ msj_error +"</div>");
    }

	});

});