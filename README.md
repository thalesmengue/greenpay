# Desafio de fluxo de transação entre usuários

## Sobre o desafio

Nesse desafio, é necessária a criação de uma aplicação que possibilite o envio de transação entre usuários,
mas se atentando a alguns detalhes para alguns detalhes: 




A criação da carteira é feita por meio de event/listener, então, no momento que um usuário é registrado,
um evento é chamado, e um listener está "ouvindo" esse evento, esse listener realizará a criação da carteira,
assim, cada usuário cadastrado irá ter sua carteira criada automaticamente, mas para esse fluxo não acabar lento em algum momento
que esteja com muitas requisições, e não tornar a experiência do usuária lenta, o listener de criação da carteira está setado para
ser assíncrono, assim, o usuário vai ser registrado, e o listener de criação da carteira jogado para uma fila.
