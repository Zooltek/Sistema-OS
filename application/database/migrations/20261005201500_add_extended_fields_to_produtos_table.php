<?php

class Migration_add_extended_fields_to_produtos_table extends CI_Migration
{
    public function up()
    {
        $fields = [
            'categoria' => [
                'type' => 'VARCHAR',
                'constraint' => 80,
                'null' => true,
                'after' => 'descricao',
            ],
            'marca' => [
                'type' => 'VARCHAR',
                'constraint' => 80,
                'null' => true,
                'after' => 'categoria',
            ],
            'modelo' => [
                'type' => 'VARCHAR',
                'constraint' => 80,
                'null' => true,
                'after' => 'marca',
            ],
            'codigo_identificacao' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'modelo',
            ],
            'localizacao' => [
                'type' => 'VARCHAR',
                'constraint' => 80,
                'null' => true,
                'after' => 'estoqueMinimo',
            ],
            'garantia' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
                'after' => 'localizacao',
            ],
            'observacoes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'garantia',
            ],
        ];

        foreach ($fields as $field_name => $field_def) {
            if (!$this->db->field_exists($field_name, 'produtos')) {
                $this->dbforge->add_column('produtos', [$field_name => $field_def]);
            }
        }
    }

    public function down()
    {
        $columns = ['categoria', 'marca', 'modelo', 'codigo_identificacao', 'localizacao', 'garantia', 'observacoes'];
        foreach ($columns as $column) {
            if ($this->db->field_exists($column, 'produtos')) {
                $this->dbforge->drop_column('produtos', $column);
            }
        }
    }
}
