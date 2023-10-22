import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder } from '@angular/forms';
import { ConexionService } from 'src/app/services/conexion.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-hotels',
  templateUrl: './hotels.component.html',
  styleUrls: ['./hotels.component.css']
})
export class HotelsComponent implements OnInit {
  formHotels: FormGroup;
  Hotels: any;

  constructor(public formulario: FormBuilder, private conexionService:ConexionService, private ruteador:Router) {
    this.formHotels = this.formulario.group({
      nombre:[''],
      direccion:[''],
      ciudad:[''],
      nit:['']
    });
  }

  ngOnInit():void{
    this.conexionService.getHotels().subscribe(response=>{
      this.Hotels = response;
    });
  }

  sendData(){
    console.log(this.formHotels.value);
    this.conexionService.AddHotel(this.formHotels.value).subscribe();
    this.ruteador.navigateByUrl("/hoteles");
  }

  deleteData(id:any,iControl:any){
    this.conexionService.DeleteHotel(id).subscribe(response=>{
      this.Hotels.splice(iControl);
    });
  }
}
