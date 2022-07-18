<?php 
    require ("fpdf/fpdf.php");
    require_once "autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";


    $idUsuario = isset($_POST["usuario"]) ? $_POST["usuario"] : 0;
    $dataInicial = isset($_POST["dataInicial"]) ? $_POST["dataInicial"] : '2000-01-01';
    $dataFinal = isset($_POST["dataFinal"]) ? $_POST["dataFinal"] : date("Y-m-d");

    $usuario = getUsuario($idUsuario);

    function getTicket($idTicket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM ticket WHERE idTicket = :id");
        $stmt->bindValue(":id", $idTicket);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new ticket($linha['idTicket'], $linha['titulo'], $linha['descricao'], $linha['dataAbertura'], $linha['dataAtualizacao'], $linha['dataFinalizacao'], $linha['categoria'], $linha['prioridade'], $linha['status'], $linha['setor'], $linha['cliente'], $linha['contato'], $linha['usuario']);
    }


    function getUsuario($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE idUsuario = :id");
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new usuario($linha['idUsuario'], $linha['nome'], $linha['sobrenome'], $linha['email'], $linha['login'], $linha['senha'], $linha['nivelAcesso'], $linha['setor'], $linha['situacao']);
    }

    function countHoras($idTicket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT horaInicial, horaFinal FROM tramite WHERE idTicket = :idTicket");
        $stmt->bindValue(":idTicket", $idTicket);
        $stmt->execute();
        $horas = 0;

        while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
            $horaInicial = $linha['horaInicial'];
            $horaFinal = $linha['horaFinal'];
            $horaInicial = strtotime($horaInicial);
            $horaFinal = strtotime($horaFinal);
            $diferenca = $horaFinal - $horaInicial;
            $horas += $diferenca;
        }

        if ($horas == 0) {
            $horas = ("00:00");
        } else {
            $horas = gmdate("H:i", $horas);
        }
        return $horas;
    }

    function rowCounter($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM ticket WHERE usuario = :idUsuario");
        $stmt->bindValue(":idUsuario", $idUsuario);
        $stmt->execute();
        return $stmt->rowCount();
    }

    function getIdTickets($idUsuario) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT idTicket FROM ticket WHERE usuario = :idUsuario");
        $stmt->bindValue(":idUsuario", $idUsuario);
        $stmt->execute();
        $tickets = array();
        while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($tickets, $linha['idTicket']);
        }
        return $tickets;
    }

    function countHorasUsuario($tickets) {
        $horas = strtotime("00:00");
        foreach ($tickets as $ticket) {
            $horas += strtotime(countHoras($ticket));
        }
        return $horas = gmdate("H:i", $horas);
    }

    $ticket = rowCounter($idUsuario);
    $horas = countHorasUsuario(getIdTickets($idUsuario));

    class PDF extends FPDF {
        function Header() {
        
        //Display Company Info
            $this->SetFont('Arial','B',14);
            $this->Cell(50,10,"HELP DESK",0,1);
            $this->SetFont('Arial','',14);
            $this->Cell(50,7,"Rua Liberto Schutz, 138",0,1);
            $this->Cell(50,7,"Rio do Sul - SC.",0,1);
            $this->Cell(50,7,"Fone: (47) 93300-0961",0,1);

        //Display INVOICE text
            $this->SetY(15);
            $this->SetX(-125);
            $this->SetFont('Arial','B',18);
            $this->Cell(20, 10, utf8_decode("RELATÓRIO DE HORAS POR TÉCNICO"), 0, 1);

        //Display Horizontal line
            $this->Line(0,48,210,48);
        }
        
        function body($usuario, $ticket, $horas) {

        //Billing Details
            $this->SetY(55);
            $this->SetX(10);
            $this->SetFont('Arial','B',12);
            $this->Cell(50,10,utf8_decode("Técnico: "),0,1);
            $this->SetFont('Arial','',12);
            $this->Cell(50, 7, utf8_decode("Nome: " . $usuario->getNome()), 0, 1);


            $this->Line(0, 75, 210, 75);
            
            
            $this->SetY(85);
            $this->SetX(10);
            $this->SetFont('Arial','B',12);
            $this->Cell(30, 9, "TICKETS: ", 1, 0, "C");
            $this->SetFont('Arial','',12);
            $this->Cell(30, 9, $ticket, 1, 0);
            
            $this->SetY(105);
            $this->SetX(10);
            $this->SetFont('Arial','B',12);
            $this->Cell(40, 9, "HORAS TRAB.: ", 1, 0, "C");
            $this->SetFont('Arial','',12);
            $this->Cell(30, 9, $horas, 1, 0);
            
        }
            function Footer(){
                //set footer position
                $this->SetY(-50);
                $this->SetFont('Arial','',12);
                
                
            }
            
        }
        //Create A4 Page with Portrait 
        $pdf = new PDF("P","mm","A4");
        $pdf->AddPage();
        $pdf->body($usuario, $ticket, $horas);
        $pdf->Output();
?>