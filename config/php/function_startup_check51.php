<?php

$i = 0;

$objQuery = mysqli_query($con, $strSQL);
while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {

    if (isset($ID[$i])) {
        $ID[$i];
    } else {
        $ID[$i] = NULL;
    }

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
    // $DATE = date("Y-m-d");
    $now = date("H");
    if ($now >= 8 && $now < 20) {
        $SHIFT = 'DAY';
    } else {
        $SHIFT = 'NIGHT';
    }

    // print_r($JUDGEMENT[$i]);

    // echo $i . '|';
    if (($JUDGEMENT[$i] == '') or ($JUDGEMENT[$i] == NULL) or (empty($JUDGEMENT))) {
        // echo $i . '|';
        $judgement = '';
        $readonly = '';
    } else {
        // echo $i . '|';
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
    $JIG_NAME = $objResult['JIG_NAME'];
    $PICTURE = '<img src="http://43.72.52.239/STARTUP_photo_body/photo_By_item/photo/' . $objResult['PICTURE'] . '" alt="" width="50%" class="img">';
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
                                    <input class="input1_value' . $ItemID . '" type="number" name="VALUE1[]" id="VALUE' . $ItemID . '"  placeholder="VALUE" VALUE="' . $CUR_VALUE1[$i] . '" step="any" " min="' . $MIN . '" max="' . $MAX . ' ' . $readonly . '>
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
        } else if ($SPEC == 'JUDGEMENT' or $SPEC == 'OK' or $SPEC == 'NG') {
            $input = "  <select name='VALUE1[]'  VALUE=" . $CUR_VALUE1[$i] . " title='$SPEC'>
                            <option VALUE='" . $CUR_VALUE1[$i] . "'>" . $CUR_VALUE1[$i] . "</option>
                            <option value='OK'>OK</option>
                            <option value='NG'>NG</option>
                            <option value='$SPEC' hidden>$SPEC</option>
                        </select>";
        } else if ($SPEC == 'PHOTO') {
            $input = '<button type="button" id="takephoto' . $ItemID . '" value = "' . $ItemID . '" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" onclick="show(this)">Take Photo</button> &nbsp <p id="imagename' . $ItemID . '">' . $CUR_VALUE1[$i] . '</p>';
            $input .= '<input type="hidden" id="nameimage' . $ItemID . '" name="VALUE1[]" hidden VALUE=' . $CUR_VALUE1[$i] . ' ></input>';
        } else if ($SPEC == 'DATE') {
            $input = "<input name='VALUE1[]' type='date' VALUE=" . $CUR_VALUE1[$i] . ">";
        } else if ($SPEC == 'TEXT') {
            $input = "
                    <div class='container'>
                        <input name='" . $ItemID . "' id='MAX" . $ItemID . "' type='hidden' VALUE='" . $MAX . "'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <input class='" . $ItemID . "' name='VALUE1[]' id='" . $ItemID . "' type='text' VALUE='" . $CUR_VALUE1[$i] . "'>
                                </div>
                            </div>
                        </div>
            ";
        ?>
            <script>
                $(document).ready(function() {
                    var value1_value = '<?php echo $CUR_VALUE1[$i] ?>';
                    var value2_value = '<?php echo $CUR_VALUE2[$i] ?>';
                    if (value1_value == '' || value1_value == '<?php echo $MAX; ?>') {
                        $(".input2_text<?php echo $ItemID; ?>").css("display", "none");
                    } else {
                        $(".input2_text<?php echo $ItemID; ?>").css("display", "block");
                        $(".input1_text<?php echo $ItemID; ?>").prop("readonly", true);
                    }

                    $(".input1_text<?php echo $ItemID; ?>").on('change', function() {
                        VALUE1 = '<?php echo $CUR_VALUE1[$i] ?>';
                        VALUE2 = '<?php echo $CUR_VALUE2[$i] ?>';
                        if (VALUE2 != null || VALUE2 != '' || VALUE2 != '<?php echo $MAX; ?>' || VALUE1 != '<?php echo $MAX; ?>') {
                            $(".input2_text<?php echo $ItemID; ?>").css("display", "block");
                            $(".input1_text<?php echo $ItemID; ?>").prop("readonly", true);
                        } else if (VALUE1 == '<?php echo $MAX; ?>' || VALUE1 == '') {
                            $(".input2_text<?php echo $ItemID; ?>").css("display", "none");
                        } else {
                            alert('VALUE OUT OF SPEC\n please fill correct value');
                            $(".input1_text<?php echo $ItemID; ?>").prop("readonly", true);
                            $(".input2_text<?php echo $ItemID; ?>").css("display", "block").focus();
                            return false;
                        }
                    })

                })
            </script>
    <?php
        } else {
            // $strSQLX = "SELECT * FROM `dropdown` WHERE DROPDOWN_NAME = '$SPEC'";
            // $objQueryX = mysqli_query($con, $strSQLX);
            // while ($objResultX = mysqli_fetch_array($objQueryX)) {
            //     $DROPDOWN_CASE = $objResultX['DROPDOWN_CASE'];
            //     $CASE[] = $DROPDOWN_CASE;
            // }
            // $i = array();
            // $input = "<select name='VALUE1[]'>";
            // foreach ($CASE as $i) {
            //     $input .= "<option value='" . $i . "'>" . $i . "</option>";
            // };
            // $input .= "</select>";

            // $input = "  <select name='VALUE1[]'  VALUE=" . $CUR_VALUE1[$i] . " title='$SPEC'>
            //                 <option VALUE='" . $CUR_VALUE1[$i] . "'>" . $CUR_VALUE1[$i] . "</option>
            //                 <option value='OK'>OK</option>
            //                 <option value='NG'>NG</option>
            //                 <option value='$SPEC' hidden>$SPEC</option>
            //             </select>";

            $input = $CUR_VALUE1[$i];
        }
    }

    ?>
    <tbody>


        <input type='hidden' name="ItemID[]" value="<?php echo $ItemID; ?>">

        <?php if ($judgement == "PASS") { ?>
            <tr id="<?php echo $ID[$i]; ?>" class="table-success">
                <!-- <td><?php echo $ID[$i]; ?></td> -->
                <td><?php echo $PROCESS; ?></td>
                <td class="text-center"><?php echo $PICTURE . '<br>' . $JIG_NAME; ?></td>
                <td><?php echo $ITEM; ?></td>
                <td><?php echo $SPEC_DES; ?></td>
                <td><?php echo $input; ?></td>
            </tr>
        <?php } else if ($judgement == "FAIL") { ?>
            <tr id="<?php echo $ID[$i]; ?>" class="table-danger">
                <!-- <td><?php echo $ID[$i]; ?></td> -->
                <td class="text-center"><?php echo $PROCESS; ?></td>
                <td><?php echo $PICTURE . '<br>' . $JIG_NAME; ?></td>
                <td><?php echo $ITEM; ?></td>
                <td><?php echo $SPEC_DES; ?></td>
                <td><?php echo $input; ?></td>
            </tr>
        <?php } else if ($judgement == '' || $judgement == 'BLANK' || $judgement == NULL) { ?>
            <tr id="<?php echo $ID[$i]; ?>" class="table-default">
                <!-- <td><?php echo $ID[$i]; ?></td> -->
                <td class="text-center"><?php echo $PROCESS; ?></td>
                <td><?php echo $PICTURE . '<br>' . $JIG_NAME; ?></td>
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
<input type='hidden' name="MODE" value="<?php echo $MODE; ?>">
<input type='hidden' name="DATE_SELECT" value="<?php echo $DATE_SELECT; ?>">
<input type='hidden' name="LINE" value="<?php echo $LINE; ?>">
<input type='hidden' name="SHIFT_SELECT" value="<?php echo $SHIFT_SELECT; ?>">
<input type='hidden' name="TYPE" value="<?php echo $TYPE; ?>">
<input type='hidden' name="MODEL" value="<?php echo $MODEL; ?>">
<input type='hidden' name="MEMBER_ID" value="<?php echo $MEMBER_ID; ?>">
<input type='hidden' name="TIME_ID" value="<?php echo $TIME_ID; ?>">