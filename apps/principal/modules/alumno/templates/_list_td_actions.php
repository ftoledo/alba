<?php
// auto-generated by sfPropelAdmin
// date: 2007/02/28 15:01:48
?>
<td>
<ul class="sf_admin_td_actions">
  <li><?php echo link_to(image_tag('../sf/sf_admin/images/edit_icon.png', array('alt' => __('edit'), 'title' => __('edit'))), 'alumno/edit?id='.$alumno->getId()) ?></li>
  <li><?php echo link_to(image_tag('../sf/sf_admin/images/delete_icon.png', array('alt' => __('delete'), 'title' => __('delete'))), 'alumno/delete?id='.$alumno->getId(), array (
  'post' => true,
  'confirm' => __('Are you sure?'),
)) ?></li>
  <li><?php echo link_to(image_tag('next.png', array('alt' => __('Ir a Cuenta'), 'title' => __('Ir a Cuenta'))), 'cuenta/verCompleta?id='.$alumno->getFkCuentaId()) ?></li>
  <li><?php echo link_to(image_tag('jeringa.gif', array('alt' => __('Vacunas'), 'title' => __('Vacunas'))), 'alumno/vacunas?id='.$alumno->getId()) ?></li>
  <li><?php echo link_to(image_tag('small/asistencia.png', array('alt' => __('Asistencia'), 'title' => __('Asistencia'))), 'alumno/asistencia?id='.$alumno->getId()) ?></li>
  <li><?php echo link_to(image_tag('small/legajo.png', array('alt' => __('Legajo'), 'title' => __('Legajo'))), 'alumno/legajo?id='.$alumno->getId()) ?></li>
</ul>
</td>