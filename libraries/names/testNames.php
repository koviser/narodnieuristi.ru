<?php
include ("./names.php");

$a = new RussianNameProcessor('������ ������� ��������');      // ������� ������� �����
echo "".$a->fullName($a->gcaseRod);
$a = new RussianNameProcessor('������� �������� ������');      // � ����� ���� ����
echo "<br/>".$a->fullName($a->gcaseRod);
$a = new RussianNameProcessor('������', '�������');        // ����� ���� ������� ������������
echo "<br/>".$a->fullName($a->gcaseRod);
$a = new RussianNameProcessor('��������', '�������', '', 'f'); // ����� ���� ������� ��� ('m' ��� 'f')
echo "<br/>".$a->fullName($a->gcaseRod);
$a = new RussianNameProcessor('������� ������� ��������');
echo "<br/>".$a->fullName($a->gcaseRod);


?>