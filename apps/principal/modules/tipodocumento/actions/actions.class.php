<?php

/**
 *    This file is part of Alba.
 * 
 *    Alba is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    Alba is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with Alba; if not, write to the Free Software
 *    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


/**
 * TipoDocumento Acciones
 *
 * @package    alba
 * @author     Jos� Luis Di Biase <josx@interorganic.com.ar>
 * @author     H�ctor Sanchez <hsanchez@pressenter.com.ar>
 * @author     Fernando Toledo <ftoledo@pressenter.com.ar>
 * @version    SVN: $Id: albaUsuarioValidator.class.php 3894 2006-12-18 17:47:12Z josx $
 * @filesource
 * @license GPL
 */

class tipodocumentoActions extends autotipodocumentoActions {
    public function preExecute() {
        $this->vista = $this->getRequestParameter('vista');
    }
    
    protected function addSortCriteria (&$c) {
        if ($sort_column = $this->getUser()->getAttribute('sort', 'nombre', 'sf_admin/tipodocumento/sort')) {
            $sort_column = Propel::getDB($c->getDbName())->quoteIdentifier($sort_column);
            if ($this->getUser()->getAttribute('type', 'asc', 'sf_admin/tipodocumento/sort') == 'asc') {
                $c->addAscendingOrderByColumn($sort_column);
            }
            else {
                $c->addDescendingOrderByColumn($sort_column);
            }
        }
    }
}
