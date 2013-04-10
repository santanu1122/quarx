<select id="selectLibrary-Collections" data-theme="a" name="gallery">
    <option value="0">Collections</option>
    <?php foreach ($collection as $col) { ?>
        
        <?php echo '<option value="'.$col->collection_id.'">'.$col->collection_name.'</option>'; ?>

    <?php } ?>
</select>

<!-- End of File -->