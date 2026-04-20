import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { EmpleadoService } from '../../../services/empleado.service';
import { Empleado } from '../../../models/models';

@Component({
  selector: 'app-empleado-form',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './empleado-form.component.html',
  styleUrl: './empleado-form.component.css'
})
export class EmpleadoFormComponent implements OnInit {
  empleado: Partial<Empleado> = {
    nombre: '', apellidos: '', dni: '',
    salarioBase: 0, irpf: 0, seguridadSocial: 0
  };
  isEditing = false;
  empleadoId: number | null = null;

  constructor(
    private empleadoService: EmpleadoService,
    private route: ActivatedRoute,
    private router: Router
  ) {}

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.isEditing = true;
      this.empleadoId = +id;
      this.empleadoService.getOne(this.empleadoId).subscribe(emp => this.empleado = emp);
    }
  }

  onSubmit(): void {
    if (this.isEditing && this.empleadoId) {
      this.empleadoService.update(this.empleadoId, this.empleado).subscribe(
        () => this.router.navigate(['/empleados'])
      );
    } else {
      this.empleadoService.create(this.empleado).subscribe(
        () => this.router.navigate(['/empleados'])
      );
    }
  }
}
