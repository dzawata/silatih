<?php

if( !function_exists('anchor') )
{
    function anchor( $url, $text )
    {
         return '<a href="'. $url .'">'.$text.'</a>';
    }
}

function probabilitas($KOLOM){
    $baris = array();
    foreach($nilai as $key => $value){
        foreach($value as $a => $b){
            $baris[$a][] = $b;
        }
    }

    $total = $mean = $dev = $jdev = $sdev = array();
    foreach($baris as $c => $d){
        // Nilai Maksimum
        $maks[$c] = max($baris[$c]);

        // Total X1 s/d Xn
        $total[$c] = array_sum($baris[$c]);

        // Mean (Rata2)
        $mean[$c] = $total[$c]/$num;

        // Standar Deviasi
        foreach($d as $e => $f){
            $dev[$c][] = pow($f-$mean[$c], 2);
        }
        $jdev[$c] = array_sum($dev[$c]);
        $sdev[$c] = sqrt($jdev[$c] / ($num-1));
    }
    }

function _epelatihan($pelatihan){
    foreach($pelatihan as $key =>$val){
        echo "<th>$val</th>";
    }
    echo "<th>TIDAK</th>";
}

function _epelatihan1($pelatihan){
    foreach($pelatihan as $key =>$val){
        echo "<th>$val</th>";
    }
}


function _enilai($item, $nilai, $total, $tipe=null){
    foreach($nilai as $key => $value){
        echo "<tr id=\"tr".($key+1)."\">";
        echo "<td>".($key+1)."</td>";
        switch($tipe){
            default:
            echo "<td>".$item[$key]."</td>";
            break;

            case 'numeric':
            echo "<td>Rp. ".number_format($item[$key],0,',','.')."</td>";
            break;

            case 'semester':
            echo "<td>Semester ".$item[$key]."</td>";
            break;

            case 'piagam':
            echo "<td>".$item[$key]." Piagam</td>";
            break;

            case 'jenkel':
            echo "<td>";
            echo ($item[$key]=="L")?"Laki-laki":"Perempuan";
            echo "</td>";
            break;

            case 'pkm':
            echo "<td>";
            echo ($item[$key]=="Y")?"Ya":"Tidak";
            echo "</td>";
            break;
        }
        foreach($value as $a => $b){
            echo "<td>$b/$total[$a]</td>";
        }
        echo "</tr>";
    }

    function _ehitung($title, $nilai, $koma=-1, $total=null){
		echo "<tr id=\"tr$title\">";
		echo "<th colspan=2>$title</th>";
		foreach($nilai as $k => $v){
			if($koma>=0){
				$val = number_format($v, $koma, ",", ".");
				if(is_null($total)) echo "<th>$val</th>";
				else echo "<th>$val/$total[$k]</th>";
			}else{
				if(is_null($total)) echo "<th>$v</th>";
				else echo "<th>$v/$total[$k]</th>";
			}
		}
		echo "</tr>";
	}
}

function _enilaipendidikan($item, $nilai, $total, $tipe=null){
    foreach($nilai as $key => $value){
        echo "<tr id=\"tr".($key+1)."\">";
        echo "<td>".($key+1)."</td>";
        switch($tipe){
            default:
            echo "<td>".$item[$key]."</td>";
            break;

            case 'numeric':
            echo "<td>Rp. ".number_format($item[$key],0,',','.')."</td>";
            break;

            case 'semester':
            echo "<td>Semester ".$item[$key]."</td>";
            break;

            case 'piagam':
            echo "<td>".$item[$key]." Piagam</td>";
            break;

            case 'jenkel':
            echo "<td>";
            echo ($item[$key]=="L")?"Laki-laki":"Perempuan";
            echo "</td>";
            break;

            case 'pkm':
            echo "<td>";
            echo ($item[$key]=="Y")?"Ya":"Tidak";
            echo "</td>";
            break;
        }
        foreach($value as $a => $b){
            echo "<td>$b/$total[$a]</td>";
        }
        echo "</tr>";
    }

    function _ehitungpendidikan($title, $nilai, $koma=-1, $total=null){
		echo "<tr id=\"tr$title\">";
		echo "<th colspan=2>$title</th>";
		foreach($nilai as $k => $v){
			if($koma>=0){
				$val = number_format($v, $koma, ",", ".");
				if(is_null($total)) echo "<th>$val</th>";
				else echo "<th>$val/$total[$k]</th>";
			}else{
				if(is_null($total)) echo "<th>$v</th>";
				else echo "<th>$v/$total[$k]</th>";
			}
		}
		echo "</tr>";
	}
}

function _enilaijurusan($item, $nilai, $total, $tipe=null){
    foreach($nilai as $key => $value){
        echo "<tr id=\"tr".($key+1)."\">";
        echo "<td>".($key+1)."</td>";
        switch($tipe){
            default:
            echo "<td>".$item[$key]."</td>";
            break;

            case 'numeric':
            echo "<td>Rp. ".number_format($item[$key],0,',','.')."</td>";
            break;

            case 'semester':
            echo "<td>Semester ".$item[$key]."</td>";
            break;

            case 'piagam':
            echo "<td>".$item[$key]." Piagam</td>";
            break;

            case 'jenkel':
            echo "<td>";
            echo ($item[$key]=="L")?"Laki-laki":"Perempuan";
            echo "</td>";
            break;

            case 'pkm':
            echo "<td>";
            echo ($item[$key]=="Y")?"Ya":"Tidak";
            echo "</td>";
            break;
        }
        foreach($value as $a => $b){
            echo "<td>$b/$total[$a]</td>";
        }
        echo "</tr>";
    }

    function _ehitungjurusan($title, $nilai, $koma=-1, $total=null){
		echo "<tr id=\"tr$title\">";
		echo "<th colspan=2>$title</th>";
		foreach($nilai as $k => $v){
			if($koma>=0){
				$val = number_format($v, $koma, ",", ".");
				if(is_null($total)) echo "<th>$val</th>";
				else echo "<th>$val/$total[$k]</th>";
			}else{
				if(is_null($total)) echo "<th>$v</th>";
				else echo "<th>$v/$total[$k]</th>";
			}
		}
		echo "</tr>";
	}
}


function _enilaistatus($item, $nilai, $total, $tipe=null){
    foreach($nilai as $key => $value){
        echo "<tr id=\"tr".($key+1)."\">";
        echo "<td>".($key+1)."</td>";
        switch($tipe){
            default:
            echo "<td>".$item[$key]."</td>";
            break;

            case 'numeric':
            echo "<td>Rp. ".number_format($item[$key],0,',','.')."</td>";
            break;

            case 'semester':
            echo "<td>Semester ".$item[$key]."</td>";
            break;

            case 'piagam':
            echo "<td>".$item[$key]." Piagam</td>";
            break;

            case 'jenkel':
            echo "<td>";
            echo ($item[$key]=="L")?"Laki-laki":"Perempuan";
            echo "</td>";
            break;

            case 'pkm':
            echo "<td>";
            echo ($item[$key]=="Y")?"Ya":"Tidak";
            echo "</td>";
            break;
        }
        foreach($value as $a => $b){
            echo "<td>$b/$total[$a]</td>";
        }
        echo "</tr>";
    }

    function _ehitungstatus($title, $nilai, $koma=-1, $total=null){
		echo "<tr id=\"tr$title\">";
		echo "<th colspan=2>$title</th>";
		foreach($nilai as $k => $v){
			if($koma>=0){
				$val = number_format($v, $koma, ",", ".");
				if(is_null($total)) echo "<th>$val</th>";
				else echo "<th>$val/$total[$k]</th>";
			}else{
				if(is_null($total)) echo "<th>$v</th>";
				else echo "<th>$v/$total[$k]</th>";
			}
		}
		echo "</tr>";
	}
}

function _epopulasi($title, $data, $koma=-1){ ?>
    <div class="panel panel-primary populasi">
        <div class="panel-body">
            <table class="table">
            <tbody>
                <?php foreach($data as $c => $d): ?>
                <tr>
                    <th rowspan=2><?php echo "P ($title | $c)";?></th>
                    <td><input type="text" placeholder="<?php echo $d->VAL;?>" title="<?php echo $d->VAL;?>" disabled></td>
                    <td rowspan=2> = <?php echo ($koma>=0)?number_format($d->NILAI,$koma,',','.'):$d->NILAI;?></td>
                </tr>
                <tr class="per">
                    <td><input type="text" placeholder="<?php echo $d->TOTAL;?>" title="<?php echo $d->TOTAL;?>" disabled></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
<?php }


function densitas_gauss($stdev, $mean, $x){
    $phi = 22/7; $e = 2.71828182846;
    $ret = 1 / sqrt(2*$phi*$stdev);
    $epo = pow($e, ( -1*((pow($x-$mean, 2)) / (2*pow($stdev, 2))) ) );
    $ret = $ret * $epo;
    return $ret;
}

