<div>
    <div class="table-responsive pt-4">
        <table class="datatable-crud-ajax {{ $tableClass }}">
            <thead>
                <tr>
                    <!-- Montando Colunas -->
                    @foreach($tableColsNames as $tableColName)
                        <th>{{mb_strtoupper($tableColName)}}</th>
                    @endforeach

                    @if($tableColActions == 'yes')
                        <!-- Montando Coluna Ação -->
                        <th width="140px">{{ mb_strtoupper('Ações') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
