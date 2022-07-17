<?php 
    require ("fpdf/fpdf.php");
    require_once "autoload.php";
    require_once "../config/Conexao.php";
    include_once "../config/default.inc.php";


    $idTicket = isset($_GET["idTicket"]) ? $_GET["idTicket"] : 0;
    $ticket = getTicket($idTicket);
    $cliente = getClientes($ticket->getCliente());
    $ordemServico = getOrdemServico($idTicket);

    function getTicket($idTicket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM ticket WHERE idTicket = :id");
        $stmt->bindValue(":id", $idTicket);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new ticket($linha['idTicket'], $linha['titulo'], $linha['descricao'], $linha['dataAbertura'], $linha['dataAtualizacao'], $linha['dataFinalizacao'], $linha['categoria'], $linha['prioridade'], $linha['status'], $linha['setor'], $linha['cliente'], $linha['contato'], $linha['usuario']);
    }

    function getClientes($idCliente) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM cliente WHERE idCliente = :id");
        $stmt->bindValue(":id", $idCliente);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new cliente($linha['idCliente'], $linha['nome'], $linha['nomeFantasia'], $linha['cpfCnpj'], $linha['endereco'], $linha['numero'], $linha['bairro'], $linha['cidade'], $linha['email'], $linha['telefone'], $linha['observacoes'], $linha['idUsuario'], $linha['situacao']);
    }

    function getOrdemServico($idTicket) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM ordemServico WHERE idTicket = :id");
        $stmt->bindValue(":id", $idTicket);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new ordemServico($linha['idOrdemServico'], $linha['valor'], $linha['descricao'], $linha['idTicket']);
    }

    function getCidadeCliente($idCidade) {
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM cidade WHERE idCidade = :idCidade");
        $stmt->bindValue(":idCidade", $idCidade);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        return new cidade($linha['idCidade'], $linha['nome'], $linha['idEstado']);
    }

    class PDF extends FPDF {
        function Header() {
        
        //Display Company Info
            $this->SetFont('Arial','B',14);
            $this->Cell(50,10,"ABC COMPUTERS",0,1);
            $this->SetFont('Arial','',14);
            $this->Cell(50,7,"West Street,",0,1);
            $this->Cell(50,7,"Salem 636002.",0,1);
            $this->Cell(50,7,"PH : 8778731770",0,1);

        //Display INVOICE text
            $this->SetY(15);
            $this->SetX(-70);
            $this->SetFont('Arial','B',18);
            $this->Cell(40, 10, utf8_decode("ORDEM DE SERVIÇO"), 0, 1);

        //Display Horizontal line
            $this->Line(0,48,210,48);
        }
        
        function body($cliente, $ticket, $ordemServico) {

        //Billing Details
            $this->SetY(55);
            $this->SetX(10);
            $this->SetFont('Arial','B',12);
            $this->Cell(50,10,"Cliente: ",0,1);
            $this->SetFont('Arial','',12);
            $this->Cell(50, 7, utf8_decode("Nome: " . $cliente->getNome()), 0, 1);
            $this->Cell(50, 7, "CPF/CNPJ: " . $cliente->getCpfCnpj(), 0, 1);
            $endereco = utf8_decode("Endereço: " . $cliente->getEndereco()) . ", " . $cliente->getNumero() . ", " . utf8_decode($cliente->getBairro()) . ", " . utf8_decode(getCidadeCliente($cliente->getCidade())->getNome());
            $this->Cell(50, 7, $endereco, 0, 1);
        
        //Display Invoice no
            $this->SetY(55);
            $this->SetX(-60);
            $this->Cell(50, 7, "Ticket: #".$ticket->getIdTicket(), 0, 1);
        
        //Display Invoice date
            $this->SetY(63);
            $this->SetX(-60);
            $this->Cell(50,7,"Data: ".$ticket->getDataAtualizacao(), 0, 1);
            
            //Display Table headings
            $this->SetY(95);
            $this->SetX(10);
            $this->SetFont('Arial','B',12);
            $this->Cell(120, 9, utf8_decode("DESCRIÇÃO"), 1, 0);
            $this->Cell(40, 9, "VALOR", 1, 0, "C");
            $this->SetFont('Arial','',12);
            
            //Display table product rows
            $this->SetY(104);
            $this->SetX(10);
            $this->Cell(120, 9, utf8_decode($ordemServico->getDescricao()), "LR", 0);
            $this->Cell(40, 9, "R$ " . $ordemServico->getValor(), "R", 1, "R");
            
            
            
        }
            function Footer(){
                //set footer position
                $this->SetY(-50);
                $this->SetFont('Arial','B',12);
                $this->Cell(0,10,"for ABC COMPUTERS",0,1,"R");
                $this->Ln(15);
                $this->SetFont('Arial','',12);
                
                $this->Cell(0,10,"Assinatura do cliente",0,1,"R");
                $this->SetFont('Arial','',10);
            }
            
        }
        //Create A4 Page with Portrait 
        $pdf = new PDF("P","mm","A4");
        $pdf->AddPage();
        $pdf->body($cliente, $ticket, $ordemServico);
        $pdf->Output();
?>