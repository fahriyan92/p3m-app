<div id="hot-skema"></div>

<script>

    skema = <?php echo json_encode($skema); ?>;
    container2 = document.getElementById("hot-skema");

    test2 = skema.map(el => { 
            const arr = [];
            arr.push(el.id);
            arr.push(el.nama);
            arr.push(2);
            arr.push(0);
            return arr;
    });

    hot2 = new Handsontable(container2, {
                height: 320,
                startRows: 5,
                startCols: 4,
                minRows: test2.length,
                minCols: 3,
                maxRows: 100,
                maxCols: 100,
                data: test2,
                rowHeaders: true,
                colHeaders: ['id','Nama Skema', 'Jumlah Anggota Polije', 'Jumlah Anggota Luar'],
                columns: [
                {
                    unique: true,
                    type: 'text',

                },
                {
                    unique: true,
                    type: 'text',
                    readOnly: true
                },
                {
                    type: "numeric",
                    validator: function(value, callback) {
                        if(value <= 0){
                            toastr["error"]("Tidak boleh 0");
                            callback(false);
                        } else {
                            callback(true);
                         }
                    }
                },             
                {
                    type: "numeric"
                },    
            ],
            hiddenColumns: {
                columns: [0]
            },  
            afterChange(changes, source) {
            if (source !== 'loadData') {

            }
            },        
            contextMenu: true,
            formulas: true,
            currentRowClassName: 'currentRow',
            currentColClassName: 'currentCol',
            autoWrapRow: true,
            sortIndicator: true,
            manualColumnResize: true,
            manualRowResize: true,
            columnSorting: true,
            columnSorting: true,
            licenseKey: 'non-commercial-and-evaluation',
    });
</script>