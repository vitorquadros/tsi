window.onload = () => {
  let cep = document.getElementById('cep');

  cep.addEventListener('blur', buscaDados);
};

async function buscaDados(event) {
  const options = { method: 'GET', mode: 'cors', cache: 'default' };

  try {
    const response = await fetch(
      'https://viacep.com.br/ws/' + this.value + '/json',
      options
    );

    const { logradouro, bairro, localidade } = await response.json();

    if (logradouro != undefined) {
      document.getElementById('logradouro').value = logradouro;
      document.getElementById('bairro').value = bairro;
      document.getElementById('cidade').value = localidade;
    } else {
      alert('CEP inválido');
    }
  } catch (error) {
    console.error(error);
  }
}
