import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { EmpleadoService } from '../../../services/empleado.service';
import { Empleado } from '../../../models/models';

@Component({
  selector: 'app-empleado-form',
  standalone: true,
  imports: [FormsModule, CommonModule],
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
  error = '';
  guardando = false;

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
    this.error = '';
    this.guardando = true;

    const accion = (this.isEditing && this.empleadoId)
      ? this.empleadoService.update(this.empleadoId, this.empleado)
      : this.empleadoService.create(this.empleado);

    accion.subscribe({
      next: () => this.router.navigate(['/empleados']),
      error: (err) => {
        this.guardando = false;
        const msg = err?.error?.errors || err?.error?.detail || err?.message || 'Error al guardar';
        this.error = typeof msg === 'string' ? msg : JSON.stringify(msg);
      }
    });
  }
}
