import { Routes } from '@angular/router';
import { authGuard } from './guards/auth.guard';
import { LoginComponent } from './components/login/login.component';
import { DashboardComponent } from './components/dashboard/dashboard.component';
import { EmpleadosComponent } from './components/empleados/empleados.component';
import { EmpleadoFormComponent } from './components/empleados/empleado-form/empleado-form.component';
import { NominasComponent } from './components/nominas/nominas.component';
import { GenerarNominaComponent } from './components/nominas/generar-nomina/generar-nomina.component';
import { VerNominaComponent } from './components/nominas/ver-nomina/ver-nomina.component';

export const routes: Routes = [
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'login', component: LoginComponent },
  { path: 'dashboard', component: DashboardComponent, canActivate: [authGuard] },
  { path: 'empleados', component: EmpleadosComponent, canActivate: [authGuard] },
  { path: 'empleados/nuevo', component: EmpleadoFormComponent, canActivate: [authGuard] },
  { path: 'empleados/editar/:id', component: EmpleadoFormComponent, canActivate: [authGuard] },
  { path: 'nominas', component: NominasComponent, canActivate: [authGuard] },
  { path: 'nominas/generar/:empleadoId', component: GenerarNominaComponent, canActivate: [authGuard] },
  { path: 'nominas/ver/:id', component: VerNominaComponent, canActivate: [authGuard] },
  { path: '**', redirectTo: 'login' }
];
