import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HotelsComponent } from './components/hotels/hotels.component';
import { ViewHotelComponent } from './components/view-hotel/view-hotel.component';

const routes: Routes = [
  {path:'',pathMatch:'full',redirectTo:'hoteles'},
  {path:'hoteles',component:HotelsComponent},
  {path:'ver-hotel/:id',component:ViewHotelComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
