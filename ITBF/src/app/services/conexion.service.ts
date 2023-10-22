import { Injectable } from '@angular/core';

import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import { Hotel } from './Hotel';
import { Room } from './Room';

@Injectable({
  providedIn: 'root'
})
export class ConexionService {
API: string = 'http://localhost/ITBF/Backend/';
  constructor(private clientHttp:HttpClient) { }

  AddHotel(dataHotel:Hotel):Observable<any>{
    return this.clientHttp.post(this.API+"?insertar=1",dataHotel);
  }

  getHotels(){
    return this.clientHttp.get(this.API);
  }

  DeleteHotel(id:any):Observable<any>{
    return this.clientHttp.get(this.API+"?borrar="+id);
  }

  getHotel(id:any):Observable<any>{
    return this.clientHttp.get(this.API+"?consultar="+id);
  }
  
  AddRoom(dataRoom:Room):Observable<any>{
    return this.clientHttp.post(this.API+"?insertar-habitacion=1",dataRoom);
  }

  DeleteRoom(id:any):Observable<any>{
    return this.clientHttp.get(this.API+"?borrarHabitacion="+id);
  }
}
