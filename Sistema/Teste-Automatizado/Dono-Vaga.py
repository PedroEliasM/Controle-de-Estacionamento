from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

# Configuração do WebDriver (nesse exemplo, estamos usando o Chrome)
driver = webdriver.Chrome()

# Acessa a página de cadastro usando o caminho absoluto com o protocolo file://
# Certifique-se de que o caminho está apontando para um arquivo HTML específico
driver.get("http://localhost/estacionamento/Sistema/vagas.php")

# Localiza o botão pelo ID e clica nele
register_button = driver.find_element(By.ID, "novaVagaButton")
register_button.click()

time.sleep(1)

# Preenche o campo Descriçaõ da Vaga
descricao_input = driver.find_element(By.ID, "iDescricao")
descricao_input.send_keys("Vaga10")

# Localiza o elemento <select> pelo ID
select_situacao = driver.find_element(By.ID, "iSituacao")
# Cria um objeto Select para manipular o <select>
select = Select(select_situacao)
# Seleciona a opção pelo valor
select.select_by_value("L")

select_empresa = driver.find_element(By.ID, "iEmpresa")
select2 = Select(select_empresa)
select2.select_by_value("1")

# Localiza o checkbox pelo ID
checkbox_element = driver.find_element(By.ID, "iAtivo")
# Marca o checkbox (se ainda não estiver marcado)
if not checkbox_element.is_selected():
    checkbox_element.click()

# Aguarda um momento para visualizar o resultado
time.sleep(2)

# Clica no botão de Cadastrar
submit_button = driver.find_element(By.ID, "criarVagaNova")
submit_button.click()

# Fecha o navegador
driver.quit()
