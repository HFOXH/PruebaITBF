import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { ConexionService } from 'src/app/services/conexion.service';

@Component({
  selector: 'app-view-hotel',
  templateUrl: './view-hotel.component.html',
  styleUrls: ['./view-hotel.component.css']
})
export class ViewHotelComponent implements OnInit{
  formHabitacion: FormGroup;
  Id: any;
  tipoHabitacion: any;
  constructor(
    private activeRoute:ActivatedRoute,
    private conexionService:ConexionService,
    public formulario: FormBuilder
  ){
    this.formHabitacion = this.formulario.group({
      nombre:[''],
      direccion:[''],
      ciudad:[''],
      nit:['']
    });
    this.Id = this.activeRoute.snapshot.paramMap.get('id');
    this.conexionService.getHotel(this.Id).subscribe(
      respuesta=>{
        this.tipoHabitacion = respuesta;
      }
    )
  }
  ngOnInit(): void{
    console.log(this.Id);
  }
  addData() {
    console.log(this.formHabitacion.value);
    const dataWithId = { ...this.formHabitacion.value, id: this.Id };
    this.conexionService.AddRoom(dataWithId).subscribe(
        (response) => {
            console.log("Respuesta del servidor:", response);
        },
        (error) => {
            console.error("Error al agregar el tipo de habitación:", error);
        }
    );
}
  deleteData(id:any,iControl:any){
    this.conexionService.DeleteRoom(id).subscribe(response=>{
      this.tipoHabitacion.splice(iControl);
    });
  }
  sendData(){
    console.log(this.formHabitacion.value);
    this.conexionService.AddHotel(this.formHabitacion.value).subscribe();
  }
}
