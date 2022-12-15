<?php
$i = 0;
$objQuery = mysqli_query($con, $strSQL);
while ($objResult = mysqli_fetch_array($objQuery)) {
    if (isset($CUR_VALUE1[$i])) {
        $CUR_VALUE1[$i];
    } else {
        $CUR_VALUE1[$i] = NULL;
    }

    if (isset($CUR_VALUE2[$i])) {
        $CUR_VALUE2[$i];
    } else {
        $CUR_VALUE2[$i] = NULL;
    }

    $now = date("H");
    if ($now >= 7 && $now <= 19) {
        $SHIFT = 'DAY';
    } else {
        $SHIFT = 'NIGHT';
    }

    if ($JUDGEMENT == '') {
        $judgement = '';
        $readonly = '';
    } else {
        $judgement = $JUDGEMENT[$i];
        if ($judgement == 'FAIL') {
            $readonly = 'readonly';
        } else {
            $readonly = '';
        }
    }

    $ItemID = $objResult['ID'];
    $BIZ = $objResult['BIZ'];
    $LINE = $objResult['LINE'];
    $TYPE = $objResult['TYPE'];
    $MODEL = $objResult['MODEL'];
    $PROCESS = $objResult['PROCESS'];
    $ITEM = $objResult['ITEM'];
    $SPEC = $objResult['SPEC'];
    $MIN = $objResult['MIN'];
    $MAX = $objResult['MAX'];
    $SPEC_DES = $objResult['SPEC_DES'];


    if (isset($SPEC)) {

        if ($SPEC == 'VALUE') {
            $input = '  <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input class="input1_value' . $ItemID . '" type="number" name="VALUE1[]" id="VALUE' . $ItemID . '"  placeholder="VALUE" VALUE="' . $CUR_VALUE1[$i] . '" step="any" ' . $readonly . '>
                                </div>
                                <div class="col-sm-12">
                                    <input class="input2_value' . $ItemID . '" type="number" name="VALUE2[]" id="ID' . $ItemID . '"placeholder="VALUE after adjust"  VALUE="' . $CUR_VALUE2[$i] . '" min="' . $MIN . '" max="' . $MAX . '" step="any" >
                                </div>
                            </div>
                        </div>';
?>
            <script>
                $(document).ready(function() {
                    if ($(".input1_value<?php echo $ItemID; ?>").val() == '' || $(".input1_value<?php echo $ItemID; ?>").val() >= <?php echo $MIN; ?> && $(".input1_value<?php echo $ItemID; ?>").val() <= <?php echo $MAX; ?>) {
                        $(".input2_value<?php echo $ItemID; ?>").css("display", "none");
                    }
                    var VALUE2 = '<?php echo $CUR_VALUE2[$i] ?>';

                    if (VALUE2) {
                        $(".input2_value<?php echo $ItemID; ?>").css("display", "block");
                        $(".input1_value<?php echo $ItemID; ?>").prop("readonly", true);
                    }

                    $(".input1_value<?php echo $ItemID; ?>").on('change', function() {
                        VALUE = $(".input1_value<?php echo $ItemID; ?>").val();
                        if (VALUE2 != null) {
                            $(".input2_value<?php echo $ItemID; ?>").css("display", "block");
                            $(".input1_value<?php echo $ItemID; ?>").prop("readonly", true);
                        }
                        if (VALUE < <?php echo $MIN; ?> || VALUE > <?php echo $MAX; ?>) {
                            $(".input2_value<?php echo $ItemID; ?>").css("display", "block");
                            $(".input1_value<?php echo $ItemID; ?>").prop("readonly", true);
                        }
                        if (VALUE >= <?php echo $MIN; ?> && VALUE <= <?php echo $MAX; ?> || VALUE == '') {
                            $(".input2_value<?php echo $ItemID; ?>").css("display", "none");

                        } else {
                            alert('VALUE OUT OF SPEC\nplease fill correct value');
                            $(".input1_value<?php echo $ItemID; ?>").prop("readonly", true);
                            return false;
                            $(".input2_value<?php echo $ItemID; ?>").css("display", "block").focus();
                        }
                    })
                })
            </script>
    <?php
        } else if ($SPEC == 'JUDGEMENT' OR $SPEC == 'OK' OR $SPEC == 'NG') {
            $input = "  <select name='VALUE1[]'  VALUE=" . $CUR_VALUE1[$i] . ">
                            <option VALUE=" . $CUR_VALUE1[$i] . ">" . $CUR_VALUE1[$i] . "</option>
                            <option value='OK'>OK</option>
                            <option value='NG'>NG</option>
                            <option value='N/A'>N/A</option>
                        </select>";
        } else if ($SPEC == 'PHOTO') {
            $input = '<button type="button" id="takephoto' . $ItemID . '" value = "' . $ItemID . '" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" onclick="show(this)">Take Photo</button> &nbsp <p id="imagename' . $ItemID . '">' . $CUR_VALUE1[$i] . '</p>';
            $input .= '<input type="hidden" id="nameimage' . $ItemID . '" name="VALUE1[]" hidden VALUE=' . $CUR_VALUE1[$i] . ' ></input>';
        } else if ($SPEC == 'DATE') {
            $input = "<input name='VALUE1[]' type='date' VALUE=" . $CUR_VALUE1[$i] . ">";
        } else {

            $strSQLX = "SELECT * FROM `dropdown` WHERE DROPDOWN_NAME = '$SPEC'";
            $objQueryX = mysqli_query($con, $strSQLX);
            while ($objResultX = mysqli_fetch_array($objQueryX)) {
                $DROPDOWN_CASE = $objResultX['DROPDOWN_CASE'];
                $CASE[] = $DROPDOWN_CASE;
            }
            $i = array();
            $input = "<select name='VALUE1[]'>";
            foreach ($CASE as $i) {
                $input .= "<option value='" . $i . "'>" . $i . "</option>";
            };
            $input .= "</select>";
        }
    }

    ?>
    <tbody>

        
        <input type='hidden' name="MODE" value="<?php echo $MODE; ?>">
        <input type='hidden' name="CHECKLATE" value="<?php echo $CHECKLATE; ?>">
        <input type='hidden' name="ItemID[]" value="<?php echo $ItemID; ?>">
        <input type='hidden' name="LINE" value="<?php echo $LINE; ?>">
        <input type='hidden' name="MODEL" value="<?php echo $MODEL; ?>">
        <input type='hidden' name="MEMBER_ID" value="<?php echo $MEMBER_ID; ?>">
        <input type='hidden' name="TIME_ID" value="<?php echo $TIME_ID; ?>">

        <?php if ($judgement == "PASS") { ?>
            <tr class="table-success">
                <td><?php echo $PROCESS; ?></td>
                <td><?php echo $ITEM; ?></td>
                <td><?php echo $SPEC_DES; ?></td>
                <td><?php echo $input; ?></td>
            </tr>
        <?php } else if ($judgement == "FAIL") { ?>
            <tr class="table-danger">
                <td><?php echo $PROCESS; ?></td>
                <td><?php echo $ITEM; ?></td>
                <td><?php echo $SPEC_DES; ?></td>
                <td><?php echo $input; ?></td>
            </tr>
        <?php } else if ($judgement == '' || $judgement == 'BLANK' || $judgement == NULL) { ?>
            <tr class="table-default">
                <td><?php echo $PROCESS; ?></td>
                <td><?php echo $ITEM; ?></td>
                <td><?php echo $SPEC_DES; ?></td>
                <td><?php echo $input; ?></td>
            </tr>
        <?php }  ?>
    </tbody>

<?php
    $i++;
}
?>